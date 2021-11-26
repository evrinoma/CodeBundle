<?php

namespace Evrinoma\CodeBundle\Repository\Bunch;

use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;

interface BunchCommandRepositoryInterface
{
//region SECTION: Public
    /**
     * @param BunchInterface $bunch
     *
     * @return bool
     * @throws BunchCannotBeSavedException
     */
    public function save(BunchInterface $bunch): bool;

    /**
     * @param BunchInterface $bunch
     *
     * @return bool
     * @throws BunchCannotBeRemovedException
     */
    public function remove(BunchInterface $bunch): bool;
//endregion Public
}