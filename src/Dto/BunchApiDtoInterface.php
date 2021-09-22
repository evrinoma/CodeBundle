<?php

namespace Evrinoma\CodeBundle\Dto;

interface BunchApiDtoInterface
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
//endregion Getters/Setters
}