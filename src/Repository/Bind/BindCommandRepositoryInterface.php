<?php

namespace Evrinoma\CodeBundle\Repository\Bind;

use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeSavedException;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;

interface BindCommandRepositoryInterface
{
    /**
     * @param BindInterface $owner
     *
     * @return bool
     * @throws BindCannotBeSavedException
     */
    public function save(BindInterface $owner): bool;

    /**
     * @param BindInterface $owner
     *
     * @return bool
     * @throws BindCannotBeRemovedException
     */
    public function remove(BindInterface $owner): bool;
}