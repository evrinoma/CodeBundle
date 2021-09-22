<?php

namespace Evrinoma\CodeBundle\Manager\Bunch;

use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

    public function getRestStatus(): int
    {
        return $this->status;
    }
}