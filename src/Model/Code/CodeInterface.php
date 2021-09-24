<?php


namespace Evrinoma\CodeBundle\Model\Code;


use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;
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

    /**
     * @param string $brief
     *
     * @return CodeInterface
     */
    public function setBrief(string $brief): CodeInterface;

    /**
     * @param string $description
     *
     * @return CodeInterface
     */
    public function setDescription(string $description): CodeInterface;

    /**
     * @param BunchInterface $bunch
     *
     * @return CodeInterface
     */
    public function setBunch(BunchInterface $bunch): CodeInterface;

    /**
     * @param OwnerInterface $owner
     *
     * @return CodeInterface
     */
    public function setOwner(OwnerInterface $owner): CodeInterface;
//endregion Getters/Setters
}