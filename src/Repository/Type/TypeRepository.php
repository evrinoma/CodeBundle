<?php

namespace Evrinoma\CodeBundle\Repository\Type;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\Codebundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\Codebundle\Exception\Type\TypeNotFoundException;
use Evrinoma\Codebundle\Exception\Type\TypeProxyException;
use Evrinoma\CodeBundle\Model\TypeInterface;

class TypeRepository extends ServiceEntityRepository implements TypeRepositoryInterface
{

//region SECTION: Public
    public function save(TypeInterface $type): bool
    {
        try {
            $this->getEntityManager()->persist($type);
        } catch (ORMInvalidArgumentException $e) {
            throw new TypeCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    public function remove(TypeInterface $type): bool
    {
        try {
            $this->getEntityManager()->remove($type);
        } catch (ORMInvalidArgumentException $e) {
            throw new TypeCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    public function proxy(string $id): TypeInterface
    {
        $em = $this->getEntityManager();

        $type = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($type)) {
            throw new TypeProxyException("Proxy doesn't exist with $id");
        }

        return $type;
    }
//endregion Public

//region SECTION: Find Filters Repository
    public function findByCriteria(TypeApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder('type');

        if ($dto->hasBrief()) {
            $builder
                ->andWhere('owner.brief = :brief')
                ->setParameter('brief', $dto->getBrief());
        }

        $type = $builder->getQuery()->getResult();

        if (count($type) === 0) {
            throw new TypeNotFoundException("Cannot find type by findByCriteria");
        }

        return $type;
    }

    public function find($id, $lockMode = null, $lockVersion = null): TypeInterface
    {
        /** @var TypeInterface $type */
        $type = parent::find($id);

        if ($type === null) {
            throw new TypeNotFoundException("Cannot find type with id $id");
        }

        return $type;
    }
//endregion Find Filters Repository
}