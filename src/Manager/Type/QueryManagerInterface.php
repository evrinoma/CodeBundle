<?php

namespace Evrinoma\CodeBundle\Manager\Type;

use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\CodeBundle\Model\TypeInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    public function criteria(TypeApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    public function get(TypeApiDtoInterface $dto): TypeInterface;
//endregion Getters/Setters
}