<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;

interface BindApiDtoInterface extends IdInterface, ActiveInterface
{
//region SECTION: Dto
    /**
     * @param CodeApiDto $codeApiDto
     *
     * @return self|DtoInterface
     */
    public function setCodeApiDto(CodeApiDto $codeApiDto): DtoInterface;

    /**
     * @param BunchApiDto $bunchApiDto
     *
     * @return self|DtoInterface
     */
    public function setBunchApiDto(BunchApiDto $bunchApiDto): DtoInterface;
//endregion SECTION: Dto
}