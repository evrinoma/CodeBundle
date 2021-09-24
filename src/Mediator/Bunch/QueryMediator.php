<?php

namespace Evrinoma\CodeBundle\Mediator\Bunch;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = 'bunch';
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto BunchApiDtoInterface */
        $dto->getTypeApiDto()->getBrief();

        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }
        if ($dto->hasDescription()) {
            $builder->andWhere($alias.'.description like :description')
                ->setParameter('description', '%'.$dto->getDescription().'%');
        }
        if ($dto->hasTypeApiDto() && $dto->getTypeApiDto()->hasId()) {
            $builder->andWhere($alias.'.name = :name')
                ->setParameter('name', '%'. $dto->getTypeApiDto()->getId().'%');
        }
    }
//endregion Public
}