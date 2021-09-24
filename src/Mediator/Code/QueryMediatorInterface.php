<?php

namespace Evrinoma\CodeBundle\Mediator\Code;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param CodeApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(CodeApiDtoInterface $dto, QueryBuilder $builder):void;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param CodeApiDtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return array
     */
    public function getResult(CodeApiDtoInterface $dto, QueryBuilder $builder): array;
}