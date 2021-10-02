<?php

namespace Evrinoma\CodeBundle\Mediator\Bind;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param BindApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(BindApiDtoInterface $dto, QueryBuilder $builder):void;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param BindApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return array
     */
    public function getResult(BindApiDtoInterface $dto, QueryBuilder $builder): array;
}