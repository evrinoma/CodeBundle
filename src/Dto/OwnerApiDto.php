<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class OwnerApiDto extends AbstractDto implements OwnerApiDtoInterface
{

//region SECTION: Public
    public function hasId(): bool
    {
        return false;
    }

    public function hasBrief(): bool
    {
        return false;
    }

    public function hasDescription(): bool
    {
        return false;
    }
//endregion Public

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    public function getId(): string
    {
        return '';
    }

    public function getBrief(): string
    {
        return '';
    }

    public function getDescription(): string
    {
        return '';
    }
//endregion Getters/Setters
}