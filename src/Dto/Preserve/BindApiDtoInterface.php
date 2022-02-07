<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\CodeBundle\Dto\BunchApiDtoInterface as BaseBunchApiDtoInterface;
use Evrinoma\CodeBundle\Dto\CodeApiDtoInterface as BaseCodeApiDtoInterface;

interface BindApiDtoInterface extends IdInterface, ActiveInterface
{
//region SECTION: Dto
    /**
     * @param BaseCodeApiDtoInterface $codeApiDto
     *
     * @return self|DtoInterface
     */
    public function setCodeApiDto(BaseCodeApiDtoInterface $codeApiDto): DtoInterface;

    /**
     * @param BaseBunchApiDtoInterface $bunchApiDto
     *
     * @return self|DtoInterface
     */
    public function setBunchApiDto(BaseBunchApiDtoInterface $bunchApiDto): DtoInterface;
//endregion SECTION: Dto
}