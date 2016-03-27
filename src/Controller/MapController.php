<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 25. 2. 2016
 * Time: 18:26
 */

namespace App\Controller;

class MapController extends AppController
{

    public function index()
    {
        require_once(ROOT . DS . 'vendor' . DS  . 'adodb-time.inc.php');
        //return $this->redirect(['controller' => 'Article', 'action' => 'novy']);
    }

    public function testnext()
    {

    }
}