<?php

namespace Evrinoma\CodeBundle\Repository\Code;

use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeSavedException;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;

interface CodeCommandRepositoryInterface
{
    /**
     * @param CodeInterface $code
     *
     * @return bool
     * @throws CodeCannotBeSavedException
     */
    public function save(CodeInterface $code): bool;

    /**
     * @param CodeInterface $code
     *
     * @return bool
     * @throws CodeCannotBeRemovedException
     */
    public function remove(CodeInterface $code): bool;
}