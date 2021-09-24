<?php

namespace Evrinoma\CodeBundle\Mediator\Bunch;

use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
//region SECTION: Public
    public function onUpdate(DtoInterface $dto, $entity): BunchInterface
    {
        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
    }

    public function onCreate(DtoInterface $dto, $entity): BunchInterface
    {
        return $entity;
    }
//endregion Public
}