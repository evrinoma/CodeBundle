<?php

namespace Evrinoma\CodeBundle\Manager\Bind;

use Evrinoma\CodeBundle\Dto\BindApiDto;
use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindNotFoundException;
use Evrinoma\CodeBundle\Exception\Bind\BindProxyException;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return array
     * @throws BindNotFoundException
     */
    public function criteria(BindApiDtoInterface $dto): array;

    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindProxyException
     */
    public function proxy(BindApiDtoInterface $dto): BindInterface;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindNotFoundException
     */
    public function get(BindApiDtoInterface $dto): BindInterface;
//endregion Getters/Setters
}