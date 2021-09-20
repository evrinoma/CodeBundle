<?php

namespace Evrinoma\CodeBundle\Manager\Owner;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Model\OwnerInterface;
use Evrinoma\CodeBundle\Repository\Owner\OwnerRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private OwnerRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(OwnerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    public function criteria(OwnerApiDtoInterface $dto): array
    {
        try {
            $owner = $this->repository->findByCriteria($dto);
        } catch (OwnerNotFoundException $e) {
            throw $e;
        }

        return $owner;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function get(OwnerApiDtoInterface $dto): OwnerInterface
    {
        try {
            $contractor = $this->repository->find($dto->getId());
        } catch (OwnerNotFoundException $e) {
            throw $e;
        }

        return $contractor;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}