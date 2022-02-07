<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\DescriptionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface as BaseTypeApiDtoInterface;

interface BunchApiDtoInterface extends IdInterface, ActiveInterface, DescriptionInterface
{
//region SECTION: Dto
    /**
     * @param BaseTypeApiDtoInterface $typeApiDto
     *
     * @return DtoInterface
     */
    public function setTypeApiDto(BaseTypeApiDtoInterface $typeApiDto): DtoInterface;
//endregion SECTION: Dto
}