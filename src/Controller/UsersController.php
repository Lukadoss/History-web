<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 16. 3. 2016
 * Time: 20:33
 */

namespace App\Controller;

use Cake\Event\Event;

class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);;
        $this->Auth->allow('registration', 'logout');
        $this->Auth->allow('lostpassword');
    }

    public function index()
    {
        $this->set('users', $this->Users->find('all'));
        $this->setAction('login');
    }

    function registration()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $query = $this->Users->find()->where(['email' => $this->request->data['email']])->first();
            if($query == null){
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($user->toArray());
                    $this->Flash->success(__('<strong>Registrace byla úspěšná!</strong>'));
                    return $this->redirect(['action' => 'detail', $this->Auth->user('user_id')]);
                }
                $this->Flash->error(__('<strong>Registrace se nepovedla!</strong> Zkuste to znovu'));
            }
            $this->Flash->error(__('<strong>Tento email již existuje!</strong>'));
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

    }

    function lostpassword()
    {

    }
}