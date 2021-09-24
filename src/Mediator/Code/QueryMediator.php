<?php

namespace Evrinoma\CodeBundle\Mediator\Code;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
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

        /** @var $dto CodeApiDtoInterface */
        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }
        if ($dto->hasBrief()) {
            $builder->andWhere($alias.'.brief like :brief')
                ->setParameter('brief', '%'.$dto->getBrief().'%');
        }
        if ($dto->hasDescription()) {
            $builder->andWhere($alias.'.description like :description')
                ->setParameter('description', '%'.$dto->getDescription().'%');
        }
        if ($dto->hasOwnerApiDto() && $dto->getOwnerApiDto()->hasId()) {
            $builder->andWhere($alias.'.owner = :owner')
                ->setParameter('owner', '%'. $dto->getOwnerApiDto()->getId().'%');
        }
        if ($dto->hasBunchApiDto() && $dto->getBunchApiDto()->hasId()) {
            $builder->andWhere($alias.'.bunch = :bunch')
                ->setParameter('bunch', '%'. $dto->getBunchApiDto()->getId().'%');
        }
    }
//endregion Public
}