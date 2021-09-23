<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface BunchApiDtoInterface extends DtoInterface
{
//region SECTION: Public
    public function hasId(): bool;
//endregion Public

//region SECTION: Dto
    public function getTypeApiDto(): TypeApiDto;
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    public function getId(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getActive(): string;
//endregion Getters/Setters
}