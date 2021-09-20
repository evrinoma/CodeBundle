<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Model\OwnerInterface;

interface OwnerFactoryInterface
{
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     */
    public function create(OwnerApiDtoInterface $dto): OwnerInterface;
}