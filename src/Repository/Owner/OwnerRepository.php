<?php

namespace Evrinoma\CodeBundle\Repository\Owner;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerProxyException;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;

class OwnerRepository extends ServiceEntityRepository implements OwnerRepositoryInterface
{

//region SECTION: Public
    /**
     * @param OwnerInterface $owner
     *
     * @return bool
     * @throws OwnerCannotBeRemovedException
     */
    public function save(OwnerInterface $owner): bool
    {
        try {
            $this->getEntityManager()->persist($owner);
        } catch (ORMInvalidArgumentException $e) {
            throw new OwnerCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param OwnerInterface $owner
     *
     * @return bool
     * @throws OwnerCannotBeSavedException
     */
    public function remove(OwnerInterface $owner): bool
    {
        try {
            $this->getEntityManager()->remove($owner);
        } catch (ORMInvalidArgumentException $e) {
            throw new OwnerCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param string $id
     *
     * @return OwnerInterface
     * @throws OwnerProxyException
     * @throws ORMException
     */
    public function proxy(string $id): OwnerInterface
    {
        $em = $this->getEntityManager();

        $owner = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($owner)) {
            throw new OwnerProxyException("Proxy doesn't exist with $id");
        }

        return $owner;
    }
//endregion Public

//region SECTION: Find Filters Repository
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return array
     * @throws OwnerNotFoundException
     */
    public function findByCriteria(OwnerApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder('owner');

        if ($dto->hasBrief()) {
            $builder
                ->andWhere('owner.brief = :brief')
                ->setParameter('brief', $dto->getBrief());
        }

        if ($dto->hasDescription()) {
            $builder->andWhere('owner.description like :description')
                ->setParameter('description', '%'.$dto->getDescription().'%');
        }

        $owner = $builder->getQuery()->getResult();

        if (count($owner) === 0) {
            throw new OwnerNotFoundException("Cannot find owner by findByCriteria");
        }

        return $owner;
    }

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return OwnerInterface
     * @throws OwnerNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): OwnerInterface
    {
        /** @var OwnerInterface $owner */
        $owner = parent::find($id);

        if ($owner === null) {
            throw new OwnerNotFoundException("Cannot find owner with id $id");
        }

        return $owner;
    }
//endregion Find Filters Repository
}