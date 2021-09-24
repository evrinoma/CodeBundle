<?php


namespace Evrinoma\CodeBundle\Model\Code;


use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface CodeInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface
{
    /**
     * @return string
     */
    public function getBrief(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return BunchInterface
     */
    public function getBunch(): BunchInterface;

    /**
     * @return OwnerInterface
     */
    public function getOwner(): OwnerInterface;
}