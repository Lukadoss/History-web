<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 16. 3. 2016
 * Time: 20:33
 */

namespace App\Controller;

use Cake\Event\Event;

class UserController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);;
        $this->Auth->allow('add', 'logout');
    }

    public function index()
    {
        $this->set('users', $this->User->find('all'));
    }

    public function view($user_id)
    {
        $user = $this->User->get($user_id);
        $this->set(compact('user'));
    }

    function registration()
    {
        $user = $this->User->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $user = $this->User->patchEntity($user, $this->request->data);
            if ($this->User->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }


    function detail()
    {

    }

    function settings()
    {

    }

    function lostPassword()
    {

    }
}