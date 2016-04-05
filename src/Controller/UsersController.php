<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 16. 3. 2016
 * Time: 20:33
 */

namespace App\Controller;

use Cake\Event\Event;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Utility\Security;
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
        $this->setAction('login');
    }

    function registration(){
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $secret = "6LdMihwTAAAAAMwgcps-oICkyK436ACqKcAemD5F";
            $recaptcha = new \ReCaptcha($secret);
            $response = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $this->request->data(['g-recaptcha-response']));
            if($user->errors() && $response->errorCodes && $response != null){
                $errors = $user->errors();
                foreach ($errors as $error){
                    foreach ($error as $err) {
                        $this->Flash->error(__($err));
                    }
                }
            }
            else {
                if ($this->request->data('forename') == null) {
                    $user['forename'] = 'Uživatel';
                }
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($user->toArray());
                    $this->Flash->success(__('<strong>Registrace byla úspěšná!</strong>'));
                    return $this->redirect(['action' => 'detail', $this->Auth->user('user_id')]);
                }
            }
        }
        $this->set('user', $user);
    }

    public function login(){
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('<strong>Přihlášení neproběhlo v pořádku!</strong> Chybný email nebo heslo.'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


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

    function settings()
    {
        //TODO: edititace nastavení
    }

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
                    $key = Security::hash($user['email'],'sha1',true);
                    $hash = sha1($user['password'].rand(0,100));
                    $url = Router::url( array('controller'=>'users','action'=>'reset'), true ).'/'.$key.'#'.$hash;
                    $email->viewVars(['url' => $url]);

                    $email->template('reset')
                        ->emailFormat('html')
                        ->subject('Změna hesla')
                        ->to($this->request->data('email'))
                        ->send();

                    $this->Flash->success('Odkaz na reset hesla byl úspěšně poslán na Váš email');
                    return $this->redirect(['action' => 'lostpassword']);
                }
                $this->Flash->error('Zadaný email neexistuje');
            }
        }
    }

    function reset($token=null){
        //$this->layout="Login";
        $this->Users->recursive=-1;
        if(!empty($token)){
            $u=$this->Users->findBytokenhash($token);
            debug($token);
//            if($u){
//                $this->Users->id=$u['User']['id'];
//                if(!empty($this->data)){
//                    $this->User->data=$this->data;
//                    $this->User->data['User']['username']=$u['User']['username'];
//                    $new_hash=sha1($u['User']['username'].rand(0,100));//created token
//                    $this->User->data['User']['tokenhash']=$new_hash;
//                    if($this->User->validates(array('fieldList'=>array('password','password_confirm')))){
//                        if($this->User->save($this->User->data))
//                        {
//                            $this->Session->setFlash('Password Has been Updated');
//                            $this->redirect(array('controller'=>'users','action'=>'login'));
//                        }
//
//                    }
//                    else{
//
//                        $this->set('errors',$this->User->invalidFields());
//                    }
//                }
//            }
//            else
//            {
//                $this->Session->setFlash('Token Corrupted,,Please Retry.the reset link work only for once.');
//            }
        }

        else{
            $this->redirect('/');
        }
    }
}