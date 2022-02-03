<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface TypeApiDtoInterface extends DtoInterface, IdInterface, BriefInterface
{
    public const TYPE = 'type';
}