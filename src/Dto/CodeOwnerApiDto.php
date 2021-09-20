<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class CodeOwnerApiDto extends AbstractDto implements CodeOwnerApiDtoInterface
{

    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }

    public function hasId(): bool
    {
        // TODO: Implement hasId() method.
    }
}