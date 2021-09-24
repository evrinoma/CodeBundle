<?php

namespace Evrinoma\CodeBindle\Mediator\Bunch;

use Evinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\CodeBundle\Model\Revoke\BunchInterface;
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