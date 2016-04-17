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
            ->contain([
                'Users' => function ($q) {
                    return $q->select(['forename', 'surname', 'email']);
                }
            ])
            ->andWhere(['onHold' => true]);
        $this->set('sources', $sources);
    }

    function accept($sourceID = null){
        if ($sourceID != null){
            $source = $this->Sources->get($sourceID);

            if($source->onHold) $source->onHold = 0;
            if($this->Sources->save($source)) {
                $this->Flash->success('Příspěvek "' . $source->name . '" byl úspěšně schválen!');
            }else{
                $this->Flash->error('Chyba při potvrzování :(');
            }
        }
        return $this->redirect($this->referer());
    }

    function edit($sourceID = null){
        if ($sourceID != null) {
            $source = $this->Sources->get($sourceID);

            if ($this->request->is('post')) {
                $this->Sources->patchEntity($source, $this->request->data);
                $source->date_from = $this->request->data('date_from');
                $source->date_to = $this->request->data('date_to');

                if ($this->Sources->save($source)) {
                    $this->Flash->success('Příspěvek "' . $source->name . '" byl úspěšně změněn!');
                } else {
                    $this->Flash->error('Chyba při ukládání změn :(');
                }
            }
        }
        return $this->redirect($this->redirect(['action' => 'index']));
    }

    function delete($sourceID = null){
        if ($sourceID != null) {
            $source = $this->Sources->get($sourceID);

            if ($this->Sources->delete($source)) {
                $this->Flash->success('Příspěvek "' . $source->name . '" byl úspěšně smazán!');
            } else {
                $this->Flash->error('Chyba při mazání :(');
            }
        }
        return $this->redirect($this->referer());
    }
}