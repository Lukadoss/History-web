<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 25. 2. 2016
 * Time: 18:26
 */

namespace App\Controller;

use Cake\Event\Event;

class MapController extends AppController
{

    public function index()
    {
        require_once(ROOT . DS . 'vendor' . DS  . 'adodb-time.inc.php');

        if (isset($_GET['float'])) {
            echo adodb_date("Y-m-d", $_GET['float']);
            die();
        }
        //return $this->redirect(['controller' => 'Article', 'action' => 'novy']);
    }
}