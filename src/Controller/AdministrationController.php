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
    /**
     * Overrides initialize in AppController
     */
    function initialize()
    {
        parent::initialize();
        $this->Auth->config('authorize', ['Controller']);
        $this->loadModel('Sources');
    }

    /**
     * Overrides beforeFilter in AppController
     * @param Event $event
     */
    function beforeFilter(Event $event)
    {
        $this->Auth->deny();
    }

    /**
     * Shows index page, loads articles from database
     */
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

    /**
     * Accepts article which is freshly created (on hold)
     * 
     * @param null $sourceID
     * @return \Cake\Network\Response|null
     */
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

    /**
     * Deletes article
     * 
     * @param null $sourceID
     * @return \Cake\Network\Response|null
     */
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