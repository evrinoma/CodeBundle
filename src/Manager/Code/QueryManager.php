<?php

namespace Evrinoma\CodeBundle\Manager\Code;

use Doctrine\ORM\ORMException;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Exception\Code\CodeProxyException;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;
use Evrinoma\CodeBundle\Repository\Code\CodeQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;


final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private CodeQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(CodeQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return array
     * @throws CodeNotFoundException
     */
    public function criteria(CodeApiDtoInterface $dto): array
    {
        try {
            $code = $this->repository->findByCriteria($dto);
        } catch (CodeNotFoundException $e) {
            throw $e;
        }

        return $code;
    }

    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeProxyException
     * @throws ORMException
     */
    public function proxy(CodeApiDtoInterface $dto): CodeInterface
    {
        try {
            $code = $this->repository->proxy($dto->getId());
        } catch (CodeProxyException $e) {
            throw $e;
        }

        return $code;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return CodeInterface
     * @throws CodeNotFoundException
     */
    public function get(CodeApiDtoInterface $dto): CodeInterface
    {
        try {
            $code = $this->repository->find($dto->getId());
        } catch (CodeNotFoundException $e) {
            throw $e;
        }

        return $code;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}