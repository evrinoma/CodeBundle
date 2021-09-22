<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

class BunchApiDto extends AbstractDto implements BunchApiDtoInterface
{

    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }
}