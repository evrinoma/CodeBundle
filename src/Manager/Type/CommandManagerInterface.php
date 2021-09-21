<?php

namespace Evrinoma\CodeBundle\Manager\Type;

use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\CodeBundle\Model\TypeInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    public function post(TypeApiDtoInterface $dto): TypeInterface;

    public function put(TypeApiDtoInterface $dto): TypeInterface;

    public function delete(TypeApiDtoInterface $dto): void;
//endregion Public
}