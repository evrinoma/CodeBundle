<?php

namespace Evrinoma\CodeBundle\Factory;

use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;

interface BindFactoryInterface
{
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     */
    public function create(BindApiDtoInterface $dto): BindInterface;
}