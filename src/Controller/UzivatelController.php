<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 16. 3. 2016
 * Time: 20:33
 */

namespace App\Controller;

use Cake\Event\Event;

class UzivatelController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    public function index()
    {
        $this->set('users', $this->Uzivatel->find('all'));
    }

    public function view($user_id)
    {
        $user = $this->Uzivatel->get($user_id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Uzivatel->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Uzivatel->patchEntity($user, $this->request->data);
            if ($this->Uzivatel->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'add']);
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

    function nastaveni()
    {

    }
}