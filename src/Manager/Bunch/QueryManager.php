<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDto;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

    private BunchQueryRepositoryInterface $repository;

    public function __construct(BunchQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }

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
        }catch (BunchNotFoundException $e) {
            throw $e;
        }

        return $bunch;
    }

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchApiDto
     * @throws BunchNotFoundException
     */
    public function get(BunchApiDtoInterface $dto): BunchApiDto
    {
        try {
            $bunch = $this->repository->find($dto->getId());
        } catch (BunchNotFoundException $e) {
            throw $e;
        }
        return $bunch;
    }
}