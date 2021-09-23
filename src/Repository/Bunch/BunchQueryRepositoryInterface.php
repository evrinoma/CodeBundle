<?php

namespace Evrinoma\CodeBundle\Repository\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;

interface BunchQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return array
     * @throws BunchNotFoundException
     */
    public function findByCriteria(BunchApiDtoInterface $dto): array;

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws BunchNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null);
//endregion Find Filters Repository
}