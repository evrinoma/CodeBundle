<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface TypeApiDtoInterface extends DtoInterface
{
    /**
     * @return bool
     */
    public function hasId(): bool;

    /**
     * @return bool
     */
    public function hasBrief(): bool;
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getBrief(): string;
}