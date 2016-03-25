<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 12. 3. 2016
 * Time: 20:35
 */

namespace App\Controller;

use Cake\Event\Event;

class ArticlesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('detail');
        $this->Auth->allow('newarticle');
    }

    function newarticle()
    {
        $this->loadModel('Districts');
        $district = $this->Districts->find('all');
        $this->set(compact("district"));
        //---
        $this->loadModel('Sources');
    }

    function detail($prispevek_id)
    {
        $this->loadModel('Sources');
        $source = $this->Sources->get($prispevek_id);
        $this->set(compact('source'));
    }

    function edit()
    {

    }
}
