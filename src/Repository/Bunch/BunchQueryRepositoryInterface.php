<?php

namespace Evrinoma\CodeBundle\Repository\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Model\BunchInterface;

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
     * @return BunchInterface
     * @throws BunchNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null):BunchInterface;
//endregion Find Filters Repository
}