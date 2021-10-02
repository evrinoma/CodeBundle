<?php


namespace Evrinoma\CodeBundle\Model\Bind;

use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;

interface BindInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface
{
    /**
     * @return BunchInterface
     */
    public function getBunch(): BunchInterface;

    /**
     * @param BunchInterface $bunch
     *
     * @return BindInterface
     */
    public function setBunch(BunchInterface $bunch): BindInterface;

    /**
     * @return CodeInterface
     */
    public function getCode(): CodeInterface;

    /**
     * @param CodeInterface $code
     *
     * @return BindInterface
     */
    public function setCode(CodeInterface $code): BindInterface;
}