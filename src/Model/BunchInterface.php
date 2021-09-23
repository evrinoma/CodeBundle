<?php


namespace Evrinoma\CodeBundle\Model;


use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface BunchInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface
{
    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     *
     * @return BunchInterface
     */
    public function setDescription(string $description): BunchInterface;

    /**
     * @param TypeInterface $type
     *
     * @return BunchInterface
     */
    public function setType(TypeInterface $type): BunchInterface;
}