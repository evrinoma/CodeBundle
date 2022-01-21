<?php


namespace Evrinoma\CodeBundle\Model\Define;

use Evrinoma\UtilsBundle\Entity\DescriptionInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface OwnerInterface extends IdInterface, DescriptionInterface
{
    /**
     * @return string
     */
    public function getBrief(): string;

    /**
     * @param string $brief
     *
     * @return AbstractOwner
     */
    public function setBrief(string $brief): self;
}