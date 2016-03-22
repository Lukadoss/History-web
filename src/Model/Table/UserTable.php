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

class UserTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('user');
        //$this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('email', 'A username is required')
            ->notEmpty('password', 'A password is required')
            ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'author']],
                'message' => 'Please enter a valid role'
            ]);
    }
}