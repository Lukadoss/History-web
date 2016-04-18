<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 12. 3. 2016
 * Time: 20:35
 */

namespace App\Controller;

use Cake\Event\Event;
require_once 'components/recaptchalib.php';

class ArticlesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['detail', 'newarticle']);
        $this->Auth->config('authorize', ['Controller']);
    }

    function newarticle()
    {
        $this->loadModel('Districts');
        $district = $this->Districts->find('all');
        $this->set(compact("district"));

        $this->loadModel('Sources');
        $source = $this->Sources->newEntity();

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

                if ($this->request->data('forename') == null){
                    $source->forename = $this->Auth->user('forename');
                    $source->surname = $this->Auth->user('surname');
                    $source->email = $this->Auth->user('email');
                }

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
        if($prispevek_id){
            $this->loadModel('Sources');
            $source = $this->Sources->get($prispevek_id);
            if($source && isset($source->user_id))
                $articleAuthor = $this->Sources->Users->get($source->user_id);
        }
        $this->set(compact('source'));
        $this->set(compact('articleAuthor'));
    }

    public function add()
    {
        $this->loadModel('Sources');
    }

    function edit($prispevek_id = null)
    {
        if($prispevek_id) {
            $this->loadModel('Sources');
            $source = $this->Sources->get($prispevek_id);
            if ($source && isset($source->user_id))
                $articleAuthor = $this->Sources->Users->get($source->user_id);

            $this->set(compact('source'));
            $this->set(compact('articleAuthor'));

            if($this->checkAuthorized()){
                //$this->redirect($this->Auth->redirectUrl());
            }

            if ($this->request->is('post')) {
                $this->Sources->patchEntity($source, $this->request->data);
                $source->date_from = $this->request->data('date_from');
                $source->date_to = $this->request->data('date_to');

                if ($this->Sources->save($source)) {
                    $this->loadModel('Users');
                    $this->Flash->success('Příspěvek "' . $source->name . '" byl úspěšně změněn!');
                    if($this->Users->get($this->Auth->user('user_id'))->isadmin == true) $this->redirect($this->redirect(['controller'=>'administration']));
                    else $this->redirect($this->redirect(['controller'=>'users', 'action'=>'detail']));
                } else {
                    $this->Flash->error('Chyba při ukládání změn :(');
                }
            }
        }
    }

    public function isAuthorized($user = null, $article = null)
    {
        if (isset($user)){
            return true;
        }

        return false;
    }

    public function checkAuthorized(){
        return true; //TODO: dodělat authoriaci
    }

}
