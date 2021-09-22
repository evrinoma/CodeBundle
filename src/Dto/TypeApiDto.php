<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class TypeApiDto extends AbstractDto implements TypeApiDtoInterface
{
    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }

    public function hasId(): bool
    {
        // TODO: Implement hasId() method.
    }

    public function hasBrief(): bool
    {
        // TODO: Implement hasBrief() method.
    }

    public function getId(): string
    {
        // TODO: Implement getId() method.
    }

    public function getBrief(): string
    {
        // TODO: Implement getBrief() method.
    }
}