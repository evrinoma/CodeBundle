<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;

interface CodeApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface, DescriptionInterface, BriefInterface
{
//region SECTION: Dto
    /**
     * @return bool
     */
    public function hasOwnerApiDto(): bool;

    public function getOwnerApiDto(): OwnerApiDto;

    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool;

    public function getTypeApiDto(): TypeApiDto;
//endregion SECTION: Dto
}
