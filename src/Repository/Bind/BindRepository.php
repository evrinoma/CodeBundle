<?php

namespace Evrinoma\CodeBundle\Repository\Bind;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\CodeBundle\Exception\Bind\BindProxyException;
use Evrinoma\CodeBundle\Mediator\Bind\QueryMediatorInterface;
use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bind\BindNotFoundException;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;
use Evrinoma\CodeBundle\Repository\Bind\BindRepositoryInterface;

class BindRepository extends ServiceEntityRepository implements BindRepositoryInterface
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
     * @param BindInterface $bind
     *
     * @return bool
     * @throws BindCannotBeSavedException
     * @throws ORMException
     */
    public function save(BindInterface $bind): bool
    {
        try {
            $this->getEntityManager()->persist($bind);
        } catch (ORMInvalidArgumentException $e) {
            throw new BindCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param BindInterface $bind
     *
     * @return bool
     */
    public function remove(BindInterface $bind): bool
    {
        $bind
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActiveToDelete();

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return array
     * @throws BindNotFoundException
     */
    public function findByCriteria(BindApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $bindes = $this->mediator->getResult($dto, $builder);

        if (count($bindes) === 0) {
            throw new BindNotFoundException("Cannot find bind by findByCriteria");
        }

        return $bindes;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws BindNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): BindInterface
    {
        /** @var BindInterface $bind */
        $bind = parent::find($id);

        if ($bind === null) {
            throw new BindNotFoundException("Cannot find bind with id $id");
        }

        return $bind;
    }

    /**
     * @param string $id
     *
     * @return BindInterface
     * @throws BindProxyException
     * @throws ORMException
     */
    public function proxy(string $id): BindInterface
    {
        $em = $this->getEntityManager();

        $bind = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($bind)) {
            throw new BindProxyException("Proxy doesn't exist with $id");
        }

        return $bind;
    }
//endregion Find Filters Repository

}