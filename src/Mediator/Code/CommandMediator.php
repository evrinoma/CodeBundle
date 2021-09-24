<?php

namespace Evrinoma\CodeBundle\Mediator\Code;

use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
//region SECTION: Public
    public function onUpdate(DtoInterface $dto, $entity): CodeInterface
    {
        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): CodeInterface
    {
        return $entity;
    }
//endregion Public
}