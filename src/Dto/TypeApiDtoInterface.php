<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;

interface TypeApiDtoInterface extends DtoInterface, IdInterface, BriefInterface
{
}