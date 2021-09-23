<?php

namespace Evrinoma\CodeBundle\Repository\Bunch;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\CodeBindle\Mediator\Bunch\QueryMediatorInterface;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Model\BunchInterface;

class BunchRepository extends ServiceEntityRepository implements BunchRepositoryInterface
{
//region SECTION: Fields
    private QueryMediatorInterface $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
//endregion Constructor

//region SECTION: Public
    public function save(BunchInterface $owner): bool
    {
        // TODO: Implement save() method.
    }

    public function remove(BunchInterface $owner): bool
    {
        // TODO: Implement remove() method.
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return array
     * @throws BunchNotFoundException
     */
    public function findByCriteria(BunchApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $bunches = $this->mediator->getResult($dto, $builder);

        if (count($bunches) === 0) {
            throw new BunchNotFoundException("Cannot find buncch by findByCriteria");
        }

        return $bunches;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws BunchNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): BunchInterface
    {
        /** @var BunchInterface $bunch */
        $bunch = parent::find($id);

        if ($bunch === null) {
            throw new BunchNotFoundException("Cannot find bunch with id $id");
        }

        return $bunch;
    }
//endregion Find Filters Repository

}