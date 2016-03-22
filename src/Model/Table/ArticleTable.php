<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 25. 2. 2016
 * Time: 18:27
 */
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticleTable extends Table
{
    public function initialize(array $config)
    {
        $this->table('district');
        //$this->addBehavior('Timestamp');
    }
}