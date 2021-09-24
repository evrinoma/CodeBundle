<?php

namespace Evrinoma\CodeBundle\Repository\Code;

use Doctrine\ORM\ORMException;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Code\CodeNotFoundException;
use Evrinoma\CodeBundle\Exception\Code\CodeProxyException;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;

interface CodeQueryRepositoryInterface
{
    /**
     * @param CodeApiDtoInterface $dto
     *
     * @return array
     * @throws CodeNotFoundException
     */
    public function findByCriteria(CodeApiDtoInterface $dto): array;

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return CodeInterface
     * @throws CodeNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null):CodeInterface;

    /**
     * @param string $id
     *
     * @return CodeInterface
     * @throws CodeProxyException
     * @throws ORMException
     */
    public function proxy(string $id): CodeInterface;
}