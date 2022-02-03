<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;

interface BindApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface
{
    /**
     * @return bool
     */
    public function hasBunchApiDto(): bool;

    /**
     * @return bool
     */
    public function hasCodeApiDto(): bool;

    /**
     * @return BunchApiDto
     */
    public function getBunchApiDto(): BunchApiDto;
    /**
     * @return CodeApiDto
     */
    public function getCodeApiDto(): CodeApiDto;
}