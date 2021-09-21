<?php

namespace Evrinoma\CodeBundle\Dto;

interface OwnerApiDtoInterface
{
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasId(): bool;

    /**
     * @return bool
     */
    public function hasBrief(): bool;

    /**
     * @return bool
     */
    public function hasDescription(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getBrief(): string;

    /**
     * @return string
     */
    public function getDescription(): string;
//endregion Getters/Setters
}