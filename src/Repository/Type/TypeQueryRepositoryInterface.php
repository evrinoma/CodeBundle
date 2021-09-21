<?php

namespace Evrinoma\CodeBundle\Repository\Type;

use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\Codebundle\Exception\Type\TypeNotFoundException;

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
     * @return
     * @throws TypeNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null);
//endregion Find Filters Repository
}