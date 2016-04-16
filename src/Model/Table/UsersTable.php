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
        $this->hasMany('Sources', [
            'foreignKey' => 'user_id'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('email')
            ->notEmpty('email', 'Zadejte email')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Email je již používán'
            ])
            ->add('email', 'valid', [
                'rule' => 'email',
                'message' => 'Email není ve správném fomátu',
            ])
            ->requirePresence('password')
            ->notEmpty('password', 'Zadejte heslo')
            ->add('password', 'length', [
                'rule'=>['minLength', 5],
                'message' => 'Délka hesla musí být větší než 5 znaků'
            ])
            ->requirePresence('pass')
            ->notEmpty('pass', 'Zopakujte heslo')
            ->add('pass', 'no-misspelling', [
                'rule'=>['compareWith', 'password'],
                'message' => 'Hesla se neshodují'
            ])
            ->allowEmpty('forename')
            ->add('forename', 'length', [
                'rule'=>['maxLength', 20],
                'message' => 'Příliš dlouhé jméno'
            ])
            ->allowEmpty('surname')
            ->add('surname', 'length', [
                'rule'=>['maxLength', 20],
                'message' => 'Příliš dlouhé příjmení'
            ]);

        return $validator;
    }
    
    public function validationPass(Validator $validator){
        $validator
            ->requirePresence('password')
            ->notEmpty('password', 'Zadejte heslo')
            ->add('password', 'length', [
                'rule' => ['minLength', 5],
                'message' => 'Délka hesla musí být větší než 5 znaků'
            ])
            ->requirePresence('pass')
            ->notEmpty('pass', 'Zopakujte heslo')
            ->add('pass', 'no-misspelling', [
                'rule' => ['compareWith', 'password'],
                'message' => 'Hesla se neshodují'
            ]);

        return $validator;
    }

    public function validationSettings(Validator $validator){
        $validator
            ->allowEmpty('forename')
            ->add('forename', 'length', [
                'rule'=>['maxLength', 20],
                'message' => 'Příliš dlouhé jméno'
            ])
            ->allowEmpty('surname')
            ->add('surname', 'length', [
                'rule'=>['maxLength', 20],
                'message' => 'Příliš dlouhé příjmení'
            ]);
        return $validator;
    }
}