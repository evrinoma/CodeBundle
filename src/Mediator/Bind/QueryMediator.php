<?php

namespace Evrinoma\CodeBundle\Mediator\Bind;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Mediator\MediatorInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = MediatorInterface::ALIAS_BUNCH;
//endregion Fields

//region SECTION: Public
    /**
     * @param DtoInterface $dto
     * @param QueryBuilder              $builder
     *
     * @return mixed
     */
    public function createQuery(DtoInterface $dto, QueryBuilder $builder):void
    {
        $alias = $this->alias();

        /** @var $dto BindApiDtoInterface */
        if ($dto->hasTypeApiDto() && $dto->getTypeApiDto()->hasBrief()) {
            $aliasType = MediatorInterface::ALIAS_TYPE;
            $builder
                ->leftJoin($alias.'.type', $aliasType)
                ->addSelect($aliasType)
                ->andWhere($aliasType.'.brief like :brief')
                ->setParameter('brief', '%'.$dto->getTypeApiDto()->getBrief().'%');
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