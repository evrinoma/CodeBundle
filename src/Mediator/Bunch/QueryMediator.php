<?php

namespace Evrinoma\CodeBindle\Mediator\Bunch;

use Doctrine\ORM\QueryBuilder;
use Evinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = 'bunch';
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {

    }
//endregion Public
}