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
        require_once(ROOT . DS . 'vendor' . DS . 'adodb-time.inc.php');

        if (isset($_GET['float'])) {
            if (isset($_GET['funct'])) {
                if ($_GET['funct'] == 'mktime') {
                    $date_arr = explode('-', $_GET['float']);
                    echo adodb_mktime(0, 0, 0, $date_arr[1], $date_arr[2], $date_arr[0]);
                    die();
                }
            } else {
                echo adodb_date("Y-m-d", $_GET['float']);
                die();
            }
        }

        $this->loadModel('Sources');
        $sources = $this->Sources->find('all', array('fields' => array('source_id', 'name', 'date_from', 'date_to', 'lat', 'lng', 'type')))
            ->where('onHold = 0');
        foreach($sources as $source){
            $source->date_from = date('Y-m-d', strtotime($source->date_from));
        }
        $this->set('sources', $sources);
        //return $this->redirect(['controller' => 'Article', 'action' => 'novy']);
    }
}