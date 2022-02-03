<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface OwnerApiDtoInterface extends DtoInterface, IdInterface, DescriptionInterface, BriefInterface
{
    public const OWNER = 'owner';
}