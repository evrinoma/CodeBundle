<?php


namespace Evrinoma\CodeBundle\Model\Define;

use Evrinoma\UtilsBundle\Entity\IdInterface;

interface OwnerInterface extends IdInterface
{
    /**
     * @return string
     */
    public function getBrief(): string;

    /**
     * @return string
     */
    public function getDescription(): string;
}