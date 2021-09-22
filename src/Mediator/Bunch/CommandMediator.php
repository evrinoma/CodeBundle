<?php

namespace Evrinoma\CodeBindle\Mediator\Bunch;

use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface;
use Evrinoma\CodeBundle\Model\BunchInterface;

class CommandMediator implements CommandMediatorInterface
{
//region SECTION: Public

//endregion Public
    public function onUpdate(BunchApiDtoInterface $dto, BunchInterface $entity): BunchInterface
    {
       return $entity;
    }

    public function onDelete(BunchApiDtoInterface $dto, BunchInterface $entity): void
    {
        // TODO: Implement onDelete() method.
    }

    public function onCreate(BunchApiDtoInterface $dto, BunchInterface $entity): BunchInterface
    {
        return $entity;
    }
}