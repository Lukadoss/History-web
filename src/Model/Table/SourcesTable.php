<?php
/**
 * Created by PhpStorm.
 * User: Seda
 * Date: 25. 3. 2016
 * Time: 18:32
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class SourcesTable extends Table
{
    public function initialize(array $config)
    {
        $this->table('source');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasOne('Districts', [
            'foreignKey' => 'district_id'
        ]);
    }
}