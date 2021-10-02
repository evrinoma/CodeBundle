<?php

namespace Evrinoma\CodeBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface BindApiDtoInterface extends DtoInterface
{
    /**
     * @return string
     */
    public function getActive(): string;

    /**
     * @return bool
     */
    public function hasBunchApiDto(): bool;
    /**
     * @return bool
     */
    public function hasCodeApiDto(): bool;
    /**
     * @return bool
     */
    public function hasActive(): bool;

    /**
     * @return bool
     */
    public function hasId(): bool;


    public function getId(): string;

    /**
     * @return BunchApiDto
     */
    public function getBunchApiDto(): BunchApiDto;
    /**
     * @return CodeApiDto
     */
    public function getCodeApiDto(): CodeApiDto;
}