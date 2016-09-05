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
use Cake\Datasource\ConnectionManager;

require_once "components/recaptchalib.php";

class UsersController extends AppController
{
    /**
     * Overrides beforeFilter in AppController
     * @param Event $event
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);;
        $this->Auth->allow(['registration', 'logout', 'lostpassword', 'reset']);
    }

    /**
     * Shows index page
     */
    public function index()
    {
        $this->set('users', $this->Users->find('all'));
        $this->setAction('detail');
    }

    /**
     * New user registration. Creates new entity of user and then saves it to the database.
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
     * User login
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
     * User logout
     * @return redirect
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


    /**
     * Shows user profile
     * @param null $user_id id uzivatele
     */
    function detail($user_id = null)
    {
        $this->loadModel('Sources');
        if($user_id == null){
            $user = $this->Users->get($this->Auth->user('user_id'));
            $this->set(compact('user'));
        }
        else{
            $user = $this->Users->get($user_id);
            $this->set(compact('user'));
        }
        $accepted_articles = $this->Sources->find()
            ->where(['user_id' => $user->user_id, 'onHold' => false]);
        $onHold_articles = $this->Sources->find()
            ->where(['user_id' => $user->user_id, 'onHold' => true]);
        $this->set('accepted', $accepted_articles);
        $this->set('onHold', $onHold_articles);
    }

    /**
     * User settings, where he can edit his forename, surname and password.
     * @return redirect
     */
    function settings()
    {
        if ($this->request->is('post')){
            $user = $this->Users->get($this->Auth->user('user_id'));
            $bool = false;

            if (!$this->request->data(['password'])){
                $bool = true;
            }elseif(!DefaultPasswordHasher::check($this->request->data('current_password'), $user['password'])) {
                $user->errors('Check password', ['Chybné staré heslo']);
            }

            $user = $this->Users->patchEntity($user, $this->request->data, ['validate'=>'settings']);
            if ($this->request->data(['password'])){
                $user = $this->Users->patchEntity($user, $this->request->data, ['validate'=>'pass']);
            }
 
            if ($bool) unset($user->password);

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
     * Processes lost password. Creates unique token and send mail to requested email address.
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
     * Loads and check tokens generated for lost password reset. After checks and saves new password.
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
     * Deletes out of date tickets.
     */
    function purgeTickets(){
        $this->Tickets->deleteAll('expires <= now()');
    }

    /**
     * Writes errors from array to single entity shown in Flash error.
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