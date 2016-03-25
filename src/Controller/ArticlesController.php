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
        if(isset($source->user_id)) $articleAuthor = $this->Sources->Users->get($source->user_id);
        $this->set(compact('source'));
        $this->set(compact('articleAuthor'));
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
    }

    function edit()
    {

    }
}
