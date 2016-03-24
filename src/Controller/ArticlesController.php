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
    }

    function newarticle()
    {
        $district = $this->Articles->find('all');
        $this->set(compact("district"));
    }

    function detail($prispevek_id)
    {
        $this->set('test', $prispevek_id);
    }

    function edit()
    {

    }
}