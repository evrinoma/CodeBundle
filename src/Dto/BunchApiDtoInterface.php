<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;

interface BunchApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface, DescriptionInterface
{
//region SECTION: Dto
    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool;

    public function getTypeApiDto(): TypeApiDto;
//endregion SECTION: Dto
}