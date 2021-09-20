<?php


namespace Evrinoma\CodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\CodeBundle\Model\AbstractOwner;

/**
 * Class BaseCode
 *
 * @package Evrinoma\CodeBundle\Entity
 * @ORM\Table(name="code_owner")
 * @ORM\Entity()
 */
class BaseOwner extends AbstractOwner
{

}