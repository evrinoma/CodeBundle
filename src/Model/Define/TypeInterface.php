<?php


namespace Evrinoma\CodeBundle\Model\Define;

use Evrinoma\UtilsBundle\Entity\IdInterface;

interface TypeInterface extends IdInterface
{
    /**
     * @return string
     */
    public function getBrief(): string;
}