<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface BunchApiDtoInterface extends DtoInterface
{
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasId(): bool;

    /**
     * @return bool
     */
    public function hasActive(): bool;

    /**
     * @return bool
     */
    public function hasDescription(): bool;
//endregion Public

//region SECTION: Dto
    /**
     * @return bool
     */
    public function hasTypeApiDto(): bool;

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