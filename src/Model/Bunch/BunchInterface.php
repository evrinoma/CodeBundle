<?php


namespace Evrinoma\CodeBundle\Model\Bunch;

use Evrinoma\CodeBundle\Model\Define\TypeInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\DescriptionInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface BunchInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, DescriptionInterface
{
    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface;

    /**
     * @param TypeInterface $type
     *
     * @return BunchInterface
     */
    public function setType(TypeInterface $type): BunchInterface;
}