<?php

namespace Evrinoma\CodeBundle\Repository\Bind;

use Doctrine\ORM\ORMException;
use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindNotFoundException;
use Evrinoma\CodeBundle\Exception\Bind\BindProxyException;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;

interface BindQueryRepositoryInterface
{
//region SECTION: Find Filters Repository
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return array
     * @throws BindNotFoundException
     */
    public function findByCriteria(BindApiDtoInterface $dto): array;

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return BindInterface
     * @throws BindNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null):BindInterface;

    /**
     * @param string $id
     *
     * @return BindInterface
     * @throws BindProxyException
     * @throws ORMException
     */
    public function proxy(string $id): BindInterface;
//endregion Find Filters Repository
}