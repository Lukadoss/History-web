<?php
/**
 * Created by PhpStorm.
 * User: Lukado
 * Date: 6. 4. 2016
 * Time: 20:25
 */

namespace App\Controller;

use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Validation\Validator;

class TicketsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['lostpassword', 'reset']);
    }

    public function index()
    {
        $this->setAction('lostpassword');
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
                    $key = Security::hash($user['password'],'md5',true);
                    $hash = sha1(date('mdY').rand(1151234,364020));
                    $url = Router::url( array('controller'=>'users','action'=>'reset'), true ).'/'.$key.'#'.$hash;
                    $email->viewVars(['url' => $url]);

//                    $ticket = $this->Tickets->newEntity();
                    debug($this->Tickets);

//                    $email->template('reset')
//                        ->emailFormat('html')
//                        ->subject('Změna hesla')
//                        ->to($this->request->data('email'))
//                        ->send();

                    $this->Flash->success('Odkaz na reset hesla byl úspěšně poslán na Váš email');
//                    return $this->redirect(['action' => 'lostpassword']);
                }
                $this->Flash->error('Zadaný email neexistuje');
            }
        }
    }

    function reset($token=null){
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
            return $this->redirect(['action' => 'lostpassword']);
        }
    }
}