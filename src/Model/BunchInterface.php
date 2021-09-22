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
}