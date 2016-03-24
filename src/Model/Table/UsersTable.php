<?php
/**
 * Created by PhpStorm.
 * User: HARD
 * Date: 21.03.2016
 * Time: 18:15
 */
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config)
    {
        $this->table('user');
        //$this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('email', 'A username is required')
            ->notEmpty('password', 'A password is required');

        return $validator;
    }
}