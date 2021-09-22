<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

    public function getRestStatus(): int
    {
        return $this->status;
    }
}