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
            if (isset($_GET['funct'])){
                if($_GET['funct'] == 'mktime'){
                    $date_arr = explode('-', $_GET['float']);
                    echo adodb_mktime(0,0,0, $date_arr[1], $date_arr[2], $date_arr[0]);
                    die();
                }
            }
            else {
                echo adodb_date("Y-m-d", $_GET['float']);
                die();
            }
        }
        //return $this->redirect(['controller' => 'Article', 'action' => 'novy']);
    }
}