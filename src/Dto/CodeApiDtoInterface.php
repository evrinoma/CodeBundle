<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface CodeApiDtoInterface extends DtoInterface
{

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasBrief(): bool;

    /**
     * @return bool
     */
    public function hasDescription(): bool;

    /**
     * @return bool
     */
    public function hasActive(): bool;

    /**
     * @return bool
     */
    public function hasId(): bool;
//endregion Public

//region SECTION: Dto
    /**
     * @return bool
     */
    public function hasOwnerApiDto(): bool;

    public function getOwnerApiDto(): OwnerApiDto;

    /**
     * @return bool
     */
    public function hasBunchApiDto(): bool;

    public function getBunchApiDto(): BunchApiDto;
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getBrief(): string;

    /**
     * @return string
     */
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
