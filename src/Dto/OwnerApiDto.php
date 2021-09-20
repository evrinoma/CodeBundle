<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\Request;

final class OwnerApiDto extends AbstractDto implements OwnerApiDtoInterface
{

    public function toDto(Request $request): DtoInterface
    {
        return $this;
    }

    public function hasId(): bool
    {
        // TODO: Implement hasId() method.
    }

    public function getId(): string
    {
        // TODO: Implement getId() method.
    }


    public function getBrief():string
    {

    }

    public function getDescription():string
    {

    }
}