<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchInvalidException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchNotFoundException;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchCannotBeSavedException
     * @throws BunchInvalidException
     */
    public function put(BunchApiDtoInterface $dto): BunchInterface;

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @return BunchInterface
     * @throws BunchNotFoundException
     * @throws BunchCannotBeCreatedException
     * @throws BunchInvalidException
     */
    public function post(BunchApiDtoInterface $dto): BunchInterface;

    /**
     * @param BunchApiDtoInterface $dto
     *
     * @throws BunchCannotBeRemovedException
     * @throws BunchNotFoundException
     */
    public function delete(BunchApiDtoInterface $dto): void;
//endregion Public

}