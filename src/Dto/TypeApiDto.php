<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class TypeApiDto extends AbstractDto implements TypeApiDtoInterface
{
    private string $id = '';

    private string $brief = '';

    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id !== '';
    }

    /**
     * @return bool
     */
    public function hasBrief(): bool
    {
        return $this->brief !== '';
    }

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
}