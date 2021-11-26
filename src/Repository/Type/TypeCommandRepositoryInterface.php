<?php

namespace Evrinoma\CodeBundle\Repository\Type;

use Evrinoma\CodeBundle\Model\Define\TypeInterface;

interface TypeCommandRepositoryInterface
{
//region SECTION: Public
    /**
     * @param TypeInterface $type
     *
     * @return bool
     */
    public function save(TypeInterface $type): bool;

    /**
     * @param TypeInterface $type
     *
     * @return bool
     */
    public function remove(TypeInterface $type): bool;
//endregion Public
}