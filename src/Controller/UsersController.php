<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 16. 3. 2016
 * Time: 20:33
 */

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Routing\Router;

require_once "components/recaptchalib.php";

class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);;
        $this->Auth->allow(['registration', 'logout', 'lostpassword', 'reset']);
    }

    public function index()
    {
        $this->set('users', $this->Users->find('all'));
        $this->setAction('detail');
    }

    /**
     * Registrace noveho uzivatele, kontrola captchou
     * @return redirect
     */
    function registration(){
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data());
            $secret = "6LdMihwTAAAAAMwgcps-oICkyK436ACqKcAemD5F";
            $recaptcha = new \ReCaptcha($secret);
            $response = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $this->request->data(['g-recaptcha-response']));
            if($user->errors()){
                $this->writeErrors($user);
            }
            elseif($response->success) {
                if ($this->request->data('forename') == null) {
                    $user['forename'] = 'Uživatel';
                }
                if ($this->Users->save($user)) {
                    unset($user->pass);
                    $this->Auth->setUser($user->toArray());
                    $this->Flash->success(__('<strong>Registrace byla úspěšná!</strong>'));
                    return $this->redirect(['action' => 'detail']);
                }
            }
            else {
                $this->Flash->error('Nebyla potvrzena captcha, zkuste to znovu');
            }
        }
        $this->set('user', $user);
    }

    /**
     * Login uzivatele
     * @return redirect
     */
    public function login(){
        if(!$this->Auth->user()) {
            if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->error(__('<strong>Přihlášení neproběhlo v pořádku!</strong> Chybný email nebo heslo.'));
            }
        }else{
            return $this->redirect(['action' => 'detail']);
        }
    }

    /**
     * Logout uzivatele
     * @return redirect
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


    /**
     * Zobrazuje profil uzivatele
     * @param null $user_id id uzivatele
     */
    function detail($user_id = null)
    {
        if($user_id == null){
            $user = $this->Users->get($this->Auth->user('user_id'));
            $this->set(compact('user'));
        }
        else{
            $user = $this->Users->get($user_id);
            $this->set(compact('user'));
        }
    }

    /**
     * Edituje nastaveni uzivatele - jmeno, prijmeni, heslo.
     * @return redirect
     */
    function settings()
    {
        if ($this->request->is('post')){
            $user = $this->Users->get($this->Auth->user('user_id'));

            if (!$this->request->data(['password'])){
                unset($user['password']);
            }elseif(!DefaultPasswordHasher::check($this->request->data('current_password'), $user['password'])) {
                $user->errors('Check password', ['Chybné staré heslo']);
            }

            $user = $this->Users->patchEntity($user, $this->request->data, ['validate'=>'settings']);
            if ($this->request->data(['password'])){
                $user = $this->Users->patchEntity($user, $this->request->data, ['validate'=>'pass']);
            }

            if(!$user->errors()){
                if(!$this->request->data(['forename']) && !$this->request->data(['surname']) && !$this->request->data(['password'])){
                    return $this->redirect($this->referer());
                }
                if(!$this->request->data(['forename'])){
                    $user->forename = $this->Auth->user('forename');
                }
                if (!$this->request->data(['surname'])){
                    $user->surname = $this->Auth->user('surname');
                }

                if($this->Users->save($user)){
                    $this->Flash->success('Profil úspěšně změněn');
                    $this->Auth->setUser($user->toArray());
                    return $this->redirect($this->referer());
                }
            }
            $this->writeErrors($user);
        }
    }

    /**
     * Zpracovava ztracene heslo, vytvari unikatni token do url a posle email na danou adresu.
     * @return redirect
     */
    function lostpassword()
    {
        if ($this->request->is('post')) {
            $validator = new Validator();
            $validator
                ->add('email', 'valid', [
                    'rule' => 'email',
                    'message' => 'Email není ve správném fomátu',
                ])
                ->notEmpty('email', 'Zadejte email');

            $errors = $validator->errors($this->request->data());

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    foreach ($error as $err) {
                        $this->Flash->error(__($err));
                    }
                }
                return $this->redirect(['action' => 'lostpassword']);
            } else {
                $user = $this->Users->find('all')
                ->where(['email'=>$this->request->data('email')])
                ->first();
                if($user){
                    $email = new Email();
                    $hash = sha1(date('dyM').rand(3333333,6666666));
                    $url = Router::url( array('controller'=>'users','action'=>'reset'), true ).'/'.$hash;
                    $email->viewVars(['url' => $url]);

                    $this->loadModel('Tickets');
                    $ticket = $this->Tickets->newEntity();
                    $ticket->hash = $hash;
                    $ticket->created = date('Y-m-d H:i:s');
                    $ticket->expires = date('Y-m-d H:i:s', strtotime('+12 hours'));
                    $ticket->user_id = $user->user_id;

                    if($this->Tickets->save($ticket)){
                        $email->template('reset')
                            ->emailFormat('html')
                            ->subject('Změna hesla')
                            ->to($this->request->data('email'))
                            ->send();

                        $this->Flash->success('Odkaz na reset hesla byl úspěšně poslán na Váš email');
                        return $this->redirect($this->referer());
                    }
                }
                $this->Flash->error('Zadaný email neexistuje');
            }
        }
    }

    /**
     * Nacita a kontroluje tokeny vygenerovane pro reset hesla. Kontroluje a uklada nove heslo.
     * @param null $token token
     * @return redirect
     */
    function reset($token=null){
        if(!empty($token)){
            $this->loadModel('Tickets');
            $this->purgeTickets();
            $ticket = $this->Tickets->find('all')
                ->where(['hash'=>$token])
                ->first();
            if($ticket){
                if ($this->request->is('post')) {
                    $user = $this->Users->get($ticket->user_id);
                    $user = $this->Users->patchEntity($user, $this->request->data, ['validate'=>'pass']);
                    if(!$user->errors()){
                        if($this->Users->save($user)){
                            $this->Flash->success('Heslo úspěšně změněno');
                            $this->Tickets->delete($ticket);
                            return $this->redirect(['action' => 'login']);
                        }
                    }
                    $this->writeErrors($user);
                }
            }
            else
            {
                $this->Flash->error('Link na reset hesla již vypršel, požádejte o reset znovu.');
                return $this->redirect(['action' => 'login']);
            }
        }
        else{
            return $this->redirect(['action' => 'login']);
        }
    }

    /**
     * Maze tickety, kterym vyprchala doba platnosti
     */
    function purgeTickets(){
        $this->Tickets->deleteAll('expires <= now()');
    }

    /**
     * Vypisuje errory z pole do jednotlivych prvku Flash erroru
     * @param $entity Entita databaze
     */
    function writeErrors($entity){
        $errors = $entity->errors();
        foreach ($errors as $error){
            foreach ($error as $err) {
                $this->Flash->error(__($err));
            }
        }
    }
}