<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 21. 3. 2016
 * Time: 23:38
 */

namespace App\Controller;

use Cake\Event\Event;

class AdministrationController extends AppController
{
    function initialize()
    {
        parent::initialize();
        $this->Auth->config('authorize', ['Controller']);
        $this->loadModel('Sources');
    }

    function beforeFilter(Event $event)
    {
        $this->Auth->deny();
    }

    function index(){
        $sources = $this->Sources->find('all')
            ->where(['onHold' => true]);
        $this->set('sources', $sources);
    }

    function accept(){
        return $this->redirect($this->referer());
    }

    function edit(){
        return $this->redirect($this->referer());
    }

    function delete(){
        return $this->redirect($this->referer());
    }


}