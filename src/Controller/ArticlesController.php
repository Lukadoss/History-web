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
        $source = $this->Sources->newEntity();
        if ($this->request->is('post')) {
            $user_id = $this->Auth->user('user_id');

            $source = $this->Sources->patchEntity($source, $this->request->data);
            $source->user_id = $user_id;
            if ($this->Sources->save($source)) {
                $this->Flash->success(__('<strong>Příspěvek byl úspěšně nahrán!</strong> Počkejte, prosím, na jeho schválení.'));
                return $this->redirect(['action' => 'new_article']);
            }
            $this->Flash->error(__('<strong>Příspěvek se nepodařilo nahrát!</strong>'));
        }
        $this->set('source', $source);
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
        $this->loadModel('Sources');
    }

    function edit()
    {

    }
}
