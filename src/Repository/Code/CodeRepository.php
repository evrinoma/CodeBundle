<?php

namespace Evrinoma\CodeBundle\Repository\Code;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Exception\Code\CodeProxyException;
use Evrinoma\CodeBundle\Mediator\Code\QueryMediatorInterface;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;

class CodeRepository extends ServiceEntityRepository implements CodeRepositoryInterface
{
    private QueryMediatorInterface $mediator;

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
//region SECTION: Public
    /**
     * @param string $id
     *
     * @return CodeInterface
     * @throws CodeProxyException
     * @throws ORMException
     */
    public function proxy(string $id): CodeInterface
    {
        $em = $this->getEntityManager();

        $code = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($code)) {
            throw new CodeProxyException("Proxy doesn't exist with $id");
        }

        return $code;
    }

    /**
     * @param CodeInterface $code
     *
     * @return bool
     * @throws CodeCannotBeSavedException
     */
    public function save(CodeInterface $code): bool
    {
        try {
            $this->getEntityManager()->persist($code);
        } catch (ORMInvalidArgumentException $e) {
            throw new CodeCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param CodeInterface $code
     *
     * @return bool
     * @throws CodeCannotBeRemovedException
     */
    public function remove(CodeInterface $code): bool
    {
        $code->setActiveToDelete();

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return array
     * @throws CodeNotFoundException
     */
    public function findByCriteria(CodeApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $codes = $this->mediator->getResult($dto, $builder);

        if (count($codes) === 0) {
            throw new CodeNotFoundException("Cannot find code by findByCriteria");
        }

        return $codes;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return CodeInterface
     * @throws CodeNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): CodeInterface
    {
        /** @var CodeInterface $code */
        $code = parent::find($id);

        if ($code === null) {
            throw new CodeNotFoundException("Cannot find code with id $id");
        }

        return $code;
    }
//endregion Find Filters Repository
}