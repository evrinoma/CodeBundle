<?php

namespace Evrinoma\CodeBundle\Manager\Bind;

use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindNotFoundException;
use Evrinoma\CodeBundle\Exception\Bind\BindProxyException;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;
use Evrinoma\CodeBundle\Repository\Bind\BindQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private BindQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(BindQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return array
     * @throws BindNotFoundException
     */
    public function criteria(BindApiDtoInterface $dto): array
    {
        try {
            $bind = $this->repository->findByCriteria($dto);
        } catch (BindNotFoundException $e) {
            throw $e;
        }

        return $bind;
    }

    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindProxyException
     */
    public function proxy(BindApiDtoInterface $dto): BindInterface
    {
        try {
            if ($dto->hasId()) {
                $bind = $this->repository->proxy($dto->getId());
            } else {
                throw new BindProxyException("Id value is not set while trying get proxy object");
            }
        } catch (BindProxyException $e) {
            throw $e;
        }

        return $bind;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindNotFoundException
     */
    public function get(BindApiDtoInterface $dto): BindInterface
    {
        try {
            $bind = $this->repository->find($dto->getId());
        } catch (BindNotFoundException $e) {
            throw $e;
        }

        return $bind;
    }
//endregion Getters/Setters
}