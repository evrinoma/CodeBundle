<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeCreatedException;
use Evrinoma\CodeBundle\Model\BunchInterface;

interface BunchFactoryInterface
{
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchCannotBeCreatedException
     */
    public function create(BunchApiDtoInterface $dto): BunchInterface;
}