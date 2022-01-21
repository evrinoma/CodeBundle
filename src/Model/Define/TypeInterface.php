<?php


namespace Evrinoma\CodeBundle\Model\Define;

use Evrinoma\UtilsBundle\Entity\IdInterface;

interface TypeInterface extends IdInterface
{
    /**
     * @return string
     */
    public function getBrief(): string;

    /**
     * @param string $brief
     *
     * @return AbstractType
     */
    public function setBrief(string $brief): self;
}