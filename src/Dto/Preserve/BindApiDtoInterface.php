<?php

namespace Evrinoma\CodeBundle\Dto\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;

interface BindApiDtoInterface extends IdInterface, ActiveInterface
{
//region SECTION: Dto
    /**
     * @param CodeApiDtoInterface $codeApiDto
     *
     * @return self|DtoInterface
     */
    public function setCodeApiDto(CodeApiDtoInterface $codeApiDto): DtoInterface;

    /**
     * @param BunchApiDtoInterface $bunchApiDto
     *
     * @return self|DtoInterface
     */
    public function setBunchApiDto(BunchApiDtoInterface $bunchApiDto): DtoInterface;
//endregion SECTION: Dto
}