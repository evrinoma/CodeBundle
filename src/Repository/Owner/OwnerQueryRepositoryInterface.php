<?php

namespace Evrinoma\CodeBundle\Repository\Owner;

use Doctrine\ORM\ORMException;
use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerProxyException;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;

interface OwnerQueryRepositoryInterface
{
//region SECTION: Public
    /**
     * @param string $id
     *
     * @return OwnerInterface
     * @throws OwnerProxyException
     * @throws ORMException
     */
    public function proxy(string $id): OwnerInterface;
//endregion Public

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
     * @return OwnerInterface
     * @throws OwnerNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): OwnerInterface;
//endregion Find Filters Repository
}