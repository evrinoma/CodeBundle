<?php

namespace Evrinoma\CodeBundle\Repository\Owner;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;

interface OwnerQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return array
     * @throws OwnerNotFoundException
     */
    public function findByCriteria(OwnerApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return mixed
     * @throws OwnerNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null);
//endregion Find Filters Repository
}