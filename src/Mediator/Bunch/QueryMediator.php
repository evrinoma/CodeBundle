<?php

namespace Evrinoma\CodeBundle\Mediator\Bunch;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Repository\AliasInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = AliasInterface::BUNCH;
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto BunchApiDtoInterface */
        if ($dto->hasTypeApiDto() && $dto->getTypeApiDto()->hasBrief()) {
            $aliasType = AliasInterface::TYPE;
            $builder
                ->leftJoin($alias.'.type', $aliasType)
                ->addSelect($aliasType)
                ->andWhere($aliasType.'.brief like :briefType')
                ->setParameter('briefType', '%'.$dto->getTypeApiDto()->getBrief().'%');
        }

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
            $builder->andWhere($alias.'.type = :type')
                ->setParameter('type', '%'.$dto->getTypeApiDto()->getId().'%');
        }
    }
//endregion Public
}