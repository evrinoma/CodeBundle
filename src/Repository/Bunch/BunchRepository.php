<?php

namespace Evrinoma\CodeBundle\Repository\Bunch;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Model\BunchInterface;

class BunchRepository extends ServiceEntityRepository implements BunchRepositoryInterface
{

    public function save(BunchInterface $owner): bool
    {
        // TODO: Implement save() method.
    }

    public function remove(BunchInterface $owner): bool
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return array
     */
    public function findByCriteria(BunchApiDtoInterface $dto): array
    {
        // TODO: Implement findByCriteria() method.
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws BunchNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {

    }

}