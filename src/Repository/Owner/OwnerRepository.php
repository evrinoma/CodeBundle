<?php

namespace Evrinoma\CodeBundle\Repository\Owner;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeSavedException;
use Evrinoma\CodeBundle\Model\OwnerInterface;

class OwnerRepository extends ServiceEntityRepository implements OwnerRepositoryInterface
{

    public function findByCriteria(OwnerApiDtoInterface $dto): array
    {
        // TODO: Implement findByCriteria() method.
    }

    public function save(OwnerInterface $owner): bool
    {
        // TODO: Implement save() method.
    }

    public function remove(OwnerInterface $owner): bool
    {
        // TODO: Implement remove() method.
    }
}