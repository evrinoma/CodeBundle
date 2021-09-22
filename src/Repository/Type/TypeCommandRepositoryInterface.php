<?php

namespace Evrinoma\CodeBundle\Repository\Type;

use Evrinoma\CodeBundle\Model\TypeInterface;

interface TypeCommandRepositoryInterface
{
    public function save(TypeInterface $type): bool;

    public function remove(TypeInterface $type): bool;
}