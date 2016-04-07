<?php
/**
 * Created by PhpStorm.
 * User: Lukado
 * Date: 5. 4. 2016
 * Time: 13:44
 */

use Cake\ORM\Table;

class TicketsTable extends Table {

    public function initialize(array $config)
    {
        $this->table('ticket');
    }
    
}