<?php
/**
 * Created by PhpStorm.
 * User: Lukado
 * Date: 6. 4. 2016
 * Time: 20:25
 */
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Ticket extends Entity
{
    protected $_accessible = [
        '*' => true,
    ];
}