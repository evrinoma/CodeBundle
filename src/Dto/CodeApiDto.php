<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class CodeApiDto extends AbstractDto implements CodeApiDtoInterface
{

    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }
}