<?php

namespace Evrinoma\CodeBundle\Repository\Type;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Type\TypeCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Type\TypeNotFoundException;
use Evrinoma\CodeBundle\Exception\Type\TypeProxyException;
use Evrinoma\CodeBundle\Model\Define\TypeInterface;

class TypeRepository extends ServiceEntityRepository implements TypeRepositoryInterface
{

//region SECTION: Public
    /**
     * @param TypeInterface $type
     *
     * @return bool
     * @throws TypeCannotBeSavedException
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(TypeInterface $type): bool
    {
        try {
            $this->getEntityManager()->persist($type);
        } catch (ORMInvalidArgumentException $e) {
            throw new TypeCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param TypeInterface $type
     *
     * @return bool
     * @throws TypeCannotBeRemovedException
     * @throws \Doctrine\ORM\ORMException
     */
    public function remove(TypeInterface $type): bool
    {
        try {
            $this->getEntityManager()->remove($type);
        } catch (ORMInvalidArgumentException $e) {
            throw new TypeCannotBeRemovedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param string $id
     *
     * @return TypeInterface
     * @throws TypeProxyException
     * @throws \Doctrine\ORM\ORMException
     */
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
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return array
     * @throws TypeNotFoundException
     */
    public function findByCriteria(TypeApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilder('type');

        if ($dto->hasBrief()) {
            $builder
                ->andWhere('type.brief like :brief')
                ->setParameter('brief', '%'.$dto->getBrief().'%');
        }

        $type = $builder->getQuery()->getResult();

        if (count($type) === 0) {
            throw new TypeNotFoundException("Cannot find type by findByCriteria");
        }

        return $type;
    }

    /**
     * @param mixed|string $id
     * @param null         $lockMode
     * @param null         $lockVersion
     *
     * @return TypeInterface
     * @throws TypeNotFoundException
     */
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