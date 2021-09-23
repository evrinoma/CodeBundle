<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class OwnerApiDto extends AbstractDto implements OwnerApiDtoInterface
{
//region SECTION: Fields
    private string $id = '';

    private string $brief = '';

    private string $description = '';
//endregion Fields

//region SECTION: Public
    public function hasId(): bool
    {
        return $this->id !== '';
    }

    public function hasBrief(): bool
    {
        return $this->brief !== '';
    }

    public function hasDescription(): bool
    {
        return $this->description !== '';
    }
//endregion Public

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBrief(): string
    {
        return $this->brief;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
//endregion Getters/Setters
}