<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Model\BunchInterface;

interface BunchFactoryInterface
{
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     */
    public function create(BunchApiDtoInterface $dto): BunchInterface;
}