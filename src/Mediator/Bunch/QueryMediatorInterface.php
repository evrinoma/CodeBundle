<?php

namespace Evrinoma\CodeBundle\Mediator\Bunch;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param BunchApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(BunchApiDtoInterface $dto, QueryBuilder $builder):void;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param BunchApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return array
     */
    public function getResult(BunchApiDtoInterface $dto, QueryBuilder $builder): array;
}