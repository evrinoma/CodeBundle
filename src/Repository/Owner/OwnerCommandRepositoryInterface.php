<?php

namespace Evrinoma\CodeBundle\Repository\Owner;

use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeSavedException;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;

interface OwnerCommandRepositoryInterface
{
    /**
     * @param OwnerInterface $owner
     *
     * @return bool
     * @throws OwnerCannotBeSavedException
     */
    public function save(OwnerInterface $owner): bool;

    /**
     * @param OwnerInterface $owner
     *
     * @return bool
     * @throws OwnerCannotBeRemovedException
     */
    public function remove(OwnerInterface $owner): bool;
}