<?php

namespace Evrinoma\CodeBundle\Repository\Type;

use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\Codebundle\Exception\Type\TypeNotFoundException;
use Evrinoma\Codebundle\Exception\Type\TypeProxyException;
use Evrinoma\CodeBundle\Model\TypeInterface;

interface TypeQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return array
     * @throws TypeNotFoundException
     */
    public function findByCriteria(TypeApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return TypeInterface
     * @throws TypeNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): TypeInterface;

    /**
     * @param string $id
     *
     * @return TypeInterface
     * @throws TypeProxyException
     */
    public function proxy(string $id): TypeInterface;
//endregion Find Filters Repository
}