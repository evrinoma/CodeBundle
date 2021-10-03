<?php

namespace Evrinoma\CodeBundle\Mediator\Code;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\CodeBundle\Mediator\MediatorInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = MediatorInterface::ALIAS_CODE;
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto CodeApiDtoInterface */
        if ($dto->hasBunchApiDto() && $dto->getBunchApiDto()->hasDescription()) {
            $aliasBunch = MediatorInterface::ALIAS_BUNCH;
            $builder
                ->leftJoin($alias.'.bunch', $aliasBunch)
                ->addSelect($aliasBunch)
                ->andWhere($aliasBunch.'.bunch like :bunch')
                ->setParameter('bunch', '%'.$dto->getBunchApiDto()->getDescription().'%');
        }

        if ($dto->hasOwnerApiDto() && ($dto->getOwnerApiDto()->hasBrief() || $dto->getOwnerApiDto()->hasDescription())) {
            $aliasType = MediatorInterface::ALIAS_OWNER;
            $builder
                ->leftJoin($alias.'.type', $aliasType)
                ->addSelect($aliasType);
             if ($dto->getOwnerApiDto()->hasBrief()) {
                 $builder->andWhere($aliasType.'.brief like :brief')
                     ->setParameter('description', '%'.$dto->getOwnerApiDto()->getBrief().'%');
             }
            if ($dto->getOwnerApiDto()->hasDescription()) {
                $builder->andWhere($aliasType.'.description like :description')
                    ->setParameter('description', '%'.$dto->getOwnerApiDto()->getDescription().'%');
            }
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
        if ($dto->hasOwnerApiDto() && $dto->getOwnerApiDto()->hasId()) {
            $builder->andWhere($alias.'.owner = :owner')
                ->setParameter('owner', '%'. $dto->getOwnerApiDto()->getId().'%');
        }
    }
//endregion Public
}