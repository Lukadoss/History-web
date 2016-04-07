<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 12. 3. 2016
 * Time: 20:35
 */

namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\FrozenTime;
require_once 'components/recaptchalib.php';

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
        debug($source->date_from);
        if ($this->request->is('post')) {
            $user_id = $this->Auth->user('user_id');
            $source->user_id = $user_id;

            $source->date_from = date('Y-m-d', strtotime($this->request->date_from));
            $secret = "6LdMihwTAAAAAMwgcps-oICkyK436ACqKcAemD5F";
            $recaptcha = new \ReCaptcha($secret);
            $response = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $this->request->data(['g-recaptcha-response']));
            if ($response->success) {
                $source = $this->Sources->patchEntity($source, $this->request->data);
                $source->date_from = $this->request->data('date_from');
                $source->date_to = $this->request->data('date_to');

                if ($this->Sources->save($source)) {
                    $this->Flash->success(__('<strong>Příspěvek byl úspěšně nahrán!</strong> Počkejte, prosím, na jeho schválení.'));
                    return $this->redirect(['action' => 'new_article']);
                }
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
