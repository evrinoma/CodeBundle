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
    protected static string $alias = MediatorInterface::ALIAS_BIND;
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
        if ($dto->hasBunchApiDto() && $dto->getBunchApiDto()->hasDescription()) {
            $aliasBunch = MediatorInterface::ALIAS_BUNCH;
            $builder
                ->leftJoin($alias.'.bunch', $aliasBunch)
                ->addSelect($aliasBunch)
                ->andWhere($aliasBunch.'.description like :descriptionbunch')
                ->setParameter('descriptionbunch', '%'.$dto->getBunchApiDto()->getDescription().'%');
        }

        if ($dto->hasCodeApiDto() && ($dto->getCodeApiDto()->hasDescription() || $dto->getCodeApiDto()->hasBrief())) {
            $aliasCode = MediatorInterface::ALIAS_CODE;
            $builder
                ->leftJoin($alias.'.code', $aliasCode)
                ->addSelect($aliasCode);

            if ($dto->getCodeApiDto()->hasBrief()) {
                $builder->andWhere($aliasCode.'.brief like :briefCode')
                    ->setParameter('briefCode', '%'.$dto->getCodeApiDto()->getBrief().'%');
            }
            if ($dto->getCodeApiDto()->hasDescription()) {
                $builder->andWhere($aliasCode.'.description like :descriptionCode')
                    ->setParameter('descriptionCode', '%'.$dto->getCodeApiDto()->getDescription().'%');
            }
        }

        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }
    }
//endregion Public
}