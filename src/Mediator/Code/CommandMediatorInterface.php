<?php

namespace Evrinoma\CodeBundle\Mediator\Code;

use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeCreatedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Code\CodeCannotBeSavedException;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;

interface CommandMediatorInterface
{
    /**
     * @param CodeApiDtoInterface $dto
     * @param CodeInterface       $entity
     *
     * @return CodeInterface
     * @throws CodeCannotBeSavedException
     */
    public function onUpdate(CodeApiDtoInterface $dto, CodeInterface $entity): CodeInterface;

    /**
     * @param CodeApiDtoInterface $dto
     * @param CodeInterface       $entity
     *
     * @throws CodeCannotBeRemovedException
     */
    public function onDelete(CodeApiDtoInterface $dto, CodeInterface $entity): void;

    /**
     * @param CodeApiDtoInterface $dto
     * @param CodeInterface       $entity
     *
     * @return CodeInterface
     * @throws CodeCannotBeSavedException
     * @throws CodeCannotBeCreatedException
     */
    public function onCreate(CodeApiDtoInterface $dto, CodeInterface $entity): CodeInterface;
}