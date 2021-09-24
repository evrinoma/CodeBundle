<?php

namespace Evrinoma\CodeBundle\Repository\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchProxyException;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;

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

    /**
     * @param string $id
     *
     * @return BunchInterface
     * @throws BunchProxyException
     */
    public function proxy(string $id): BunchInterface;
//endregion Find Filters Repository
}