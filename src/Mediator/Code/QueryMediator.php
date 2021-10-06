<?php

namespace Evrinoma\CodeBundle\Mediator\Code;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\CodeBundle\Repository\AliasInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
//region SECTION: Fields
    protected static string $alias = AliasInterface::CODE;
//endregion Fields

//region SECTION: Public
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto CodeApiDtoInterface */
        if ($dto->hasTypeApiDto() && $dto->getTypeApiDto()->hasBrief()) {
            $aliasType = AliasInterface::TYPE;
            $builder
                ->leftJoin($alias.'.type', $aliasType)
                ->addSelect($aliasType)
                ->andWhere($aliasType.'.brief like :briefType')
                ->setParameter('briefType', '%'.$dto->getTypeApiDto()->getBrief().'%');
        }

        if ($dto->hasOwnerApiDto() && ($dto->getOwnerApiDto()->hasBrief() || $dto->getOwnerApiDto()->hasDescription())) {
            $aliasOwner = AliasInterface::OWNER;
            $builder
                ->leftJoin($alias.'.type', $aliasOwner)
                ->addSelect($aliasOwner);
             if ($dto->getOwnerApiDto()->hasBrief()) {
                 $builder->andWhere($aliasOwner.'.brief like :briefOwner')
                     ->setParameter('briefOwner', '%'.$dto->getOwnerApiDto()->getBrief().'%');
             }
            if ($dto->getOwnerApiDto()->hasDescription()) {
                $builder->andWhere($aliasOwner.'.description like :descriptionOwner')
                    ->setParameter('descriptionOwner', '%'.$dto->getOwnerApiDto()->getDescription().'%');
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
        if ($dto->hasTypeApiDto() && $dto->getTypeApiDto()->hasId()) {
            $builder->andWhere($alias.'.type = :type')
                ->setParameter('type', '%'.$dto->getTypeApiDto()->getId().'%');
        }
    }
//endregion Public
}