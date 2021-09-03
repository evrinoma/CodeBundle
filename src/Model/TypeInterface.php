<?php


namespace Evrinoma\CodeBundle\Model;

use Evrinoma\UtilsBundle\Entity\IdInterface;

interface TypeInterface extends IdInterface
{
    /**
     * @return string
     */
    public function getBrief(): string;
}