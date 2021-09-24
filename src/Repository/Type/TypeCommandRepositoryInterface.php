<?php

namespace Evrinoma\CodeBundle\Repository\Type;

use Evrinoma\CodeBundle\Model\Define\TypeInterface;

interface TypeCommandRepositoryInterface
{
    public function save(TypeInterface $type): bool;

    public function remove(TypeInterface $type): bool;
}