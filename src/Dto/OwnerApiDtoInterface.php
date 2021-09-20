<?php

namespace Evrinoma\CodeBundle\Dto;

interface OwnerApiDtoInterface
{
    /**
     * @return bool
     */
    public function hasId(): bool;
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getBrief():string;

    /**
     * @return string
     */
    public function getDescription():string;
}