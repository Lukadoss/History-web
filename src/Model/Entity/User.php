<?php
/**
 * Created by PhpStorm.
 * User: HARD
 * Date: 21.03.2016
 * Time: 18:36
 */
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected $_accessible = [
        '*' => true,
    ];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    protected function _getFullName()
    {
        return $this->_properties['forename'] . '  ' .
        $this->_properties['surname'];
    }
}