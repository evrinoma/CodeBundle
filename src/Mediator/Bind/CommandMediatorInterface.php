<?php

namespace Evrinoma\CodeBundle\Mediator\Bind;

use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeSavedException;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;

interface CommandMediatorInterface
{
    /**
     * @param BindApiDtoInterface $dto
     * @param BindInterface       $entity
     *
     * @return BindInterface
     * @throws BindCannotBeSavedException
     */
    public function onUpdate(BindApiDtoInterface $dto, BindInterface $entity): BindInterface;

    /**
     * @param BindApiDtoInterface $dto
     * @param BindInterface       $entity
     *
     * @throws BindCannotBeRemovedException
     */
    public function onDelete(BindApiDtoInterface $dto, BindInterface $entity): void;

    /**
     * @param BindApiDtoInterface $dto
     * @param BindInterface       $entity
     *
     * @return BindInterface
     * @throws BindCannotBeSavedException
     * @throws BindCannotBeCreatedException
     */
    public function onCreate(BindApiDtoInterface $dto, BindInterface $entity): BindInterface;
}