<?php

namespace Evrinoma\CodeBundle\Repository\Owner;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;

class OwnerRepository extends ServiceEntityRepository implements OwnerRepositoryInterface
{

//region SECTION: Public
    public function save(OwnerInterface $owner): bool
    {
        try {
            $this->getEntityManager()->persist($owner);
        } catch (ORMInvalidArgumentException $e) {
            throw new OwnerCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    public function remove(OwnerInterface $owner): bool
    {
        try {
            $this->getEntityManager()->remove($owner);
        } catch (ORMInvalidArgumentException $e) {
            throw new OwnerCannotBeRemovedException($e->getMessage());
        }

        return true;
    }
//endregion Public

//region SECTION: Find Filters Repository
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