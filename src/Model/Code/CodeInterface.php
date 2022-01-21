<?php


namespace Evrinoma\CodeBundle\Model\Code;


use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;
use Evrinoma\CodeBundle\Model\Define\TypeInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface CodeInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface
{
//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getBrief(): string;

    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;

    /**
     * @return OwnerInterface
     */
    public function getOwner(): OwnerInterface;

    /**
     * @param string $brief
     *
     * @return CodeInterface
     */
    public function setBrief(string $brief): CodeInterface;

    /**
     * @param TypeInterface $type
     *
     * @return CodeInterface
     */
    public function setType(TypeInterface $type): CodeInterface;

    /**
     * @param OwnerInterface $owner
     *
     * @return CodeInterface
     */
    public function setOwner(OwnerInterface $owner): CodeInterface;
//endregion Getters/Setters
}