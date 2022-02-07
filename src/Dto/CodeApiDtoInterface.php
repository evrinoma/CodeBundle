<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\BriefInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface CodeApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface, DescriptionInterface, BriefInterface
{
    public const CODE = 'code';
//region SECTION: Dto

    /**
     * @return bool
     */
    public function hasOwnerApiDto(): bool;

    public function getOwnerApiDto(): OwnerApiDtoInterface;

    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool;

    public function getTypeApiDto(): TypeApiDtoInterface;
//endregion SECTION: Dto
}
