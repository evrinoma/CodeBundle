<?php

namespace Evrinoma\CodeBindle\Mediator\Bunch;


use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bunch\BunchCannotBeSavedException;
use Evrinoma\CodeBundle\Model\Revoke\BunchInterface;

interface CommandMediatorInterface
{
//region SECTION: Public
    /**
     * @param BunchApiDtoInterface $dto
     * @param BunchInterface       $entity
     *
     * @return BunchInterface
     * @throws BunchCannotBeSavedException
     */
    public function onUpdate(BunchApiDtoInterface $dto, BunchInterface $entity): BunchInterface;

    /**
     * @param BunchApiDtoInterface $dto
     * @param BunchInterface       $entity
     *
     * @throws BunchCannotBeRemovedException
     */
    public function onDelete(BunchApiDtoInterface $dto, BunchInterface $entity): void;

    /**
     * @param BunchApiDtoInterface $dto
     * @param BunchInterface       $entity
     *
     * @return BunchInterface
     * @throws BunchCannotBeSavedException
     * @throws BunchCannotBeCreatedException
     */
    public function onCreate(BunchApiDtoInterface $dto, BunchInterface $entity): BunchInterface;
//endregion Public
}