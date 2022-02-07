<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface BunchApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface, DescriptionInterface
{
    public const BUNCH = 'bunch';
//region SECTION: Dto
    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool;

    public function getTypeApiDto(): TypeApiDtoInterface;
//endregion SECTION: Dto
}