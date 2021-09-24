<?php

namespace Evrinoma\CodeBundle\Repository\Bunch;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\CodeBundle\Exception\Bunch\BunchProxyException;
use Evrinoma\CodeBundle\Mediator\Bunch\QueryMediatorInterface;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;

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
    /**
     * @param BunchInterface $owner
     *
     * @return bool
     * @throws BunchCannotBeSavedException
     * @throws ORMException
     */
    public function save(BunchInterface $owner): bool
    {
        try {
            $this->getEntityManager()->persist($owner);
        } catch (ORMInvalidArgumentException $e) {
            throw new BunchCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param BunchInterface $owner
     *
     * @return bool
     */
    public function remove(BunchInterface $owner): bool
    {
        $owner->setActiveToDelete();

        return true;
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
            throw new BunchNotFoundException("Cannot find bunch by findByCriteria");
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

    /**
     * @param string $id
     *
     * @return BunchInterface
     * @throws BunchProxyException
     * @throws ORMException
     */
    public function proxy(string $id): BunchInterface
    {
        $em = $this->getEntityManager();

        $bunch = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($bunch)) {
            throw new BunchProxyException("Proxy doesn't exist with $id");
        }

        return $bunch;
    }
//endregion Find Filters Repository

}