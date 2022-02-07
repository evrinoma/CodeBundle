<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Mutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;

interface OwnerApiDtoInterface extends IdInterface, BriefInterface, DescriptionInterface
{
}
