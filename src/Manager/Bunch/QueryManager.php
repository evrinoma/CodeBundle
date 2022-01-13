<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchProxyException;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Repository\Bunch\BunchQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private BunchQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(BunchQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return array
     * @throws BunchNotFoundException
     */
    public function criteria(BunchApiDtoInterface $dto): array
    {
        try {
            $bunch = $this->repository->findByCriteria($dto);
        } catch (BunchNotFoundException $e) {
            throw $e;
        }

        return $bunch;
    }

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchProxyException
     */
    public function proxy(BunchApiDtoInterface $dto): BunchInterface
    {
        try {
            if ($dto->hasId()) {
                $bunch = $this->repository->proxy($dto->getId());
            } else {
                throw new BunchProxyException("Id value is not set while trying get proxy object");
            }
        } catch (BunchProxyException $e) {
            throw $e;
        }

        return $bunch;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchNotFoundException
     */
    public function get(BunchApiDtoInterface $dto): BunchInterface
    {
        try {
            $bunch = $this->repository->find($dto->getId());
        } catch (BunchNotFoundException $e) {
            throw $e;
        }

        return $bunch;
    }
//endregion Getters/Setters
}