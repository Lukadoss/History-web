<?php
/**
 * Created by PhpStorm.
 * User: Lukado
 * Date: 6. 4. 2016
 * Time: 20:25
 */

use Cake\ORM\Entity;

class User extends Entity
{
    protected $_accessible = [
        '*' => true,
    ];
}