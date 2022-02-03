<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\CodeBundle\Dto\TypeApiDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;

interface BunchApiDtoInterface extends IdInterface, ActiveInterface, DescriptionInterface
{
//region SECTION: Dto
    /**
     * @param TypeApiDto $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(TypeApiDto $typeApiDto): DtoInterface;
//endregion SECTION: Dto
}