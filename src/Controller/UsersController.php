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

require_once "components/recaptchalib.php";

class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);;
        $this->Auth->allow('registration', 'logout', 'lostpassword');
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
            if($user->errors() & $response->errorCodes){
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

    function httpPost($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
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
        $validator = new Validator();
        $validator
            ->add('email', 'valid', [
                'rule' => 'email',
                'message' => 'Email není ve správném fomátu',
            ]);

        $errors = $validator->errors($this->request->data());

        if(!empty($errors)){
            foreach ($errors as $error){
                foreach ($error as $err) {
                    $this->Flash->error(__($err));
                }
            }
            return $this->redirect(['action' => 'lostpassword']);
        }else{
            //TODO: heslo resend logika
        }
    }
}