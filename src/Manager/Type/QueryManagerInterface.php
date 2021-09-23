<?php

namespace Evrinoma\CodeBundle\Manager\Type;

use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\Codebundle\Exception\Type\TypeNotFoundException;
use Evrinoma\Codebundle\Exception\Type\TypeProxyException;
use Evrinoma\CodeBundle\Model\TypeInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return array
     * @throws TypeNotFoundException
     */
    public function criteria(TypeApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeNotFoundException
     */
    public function get(TypeApiDtoInterface $dto): TypeInterface;
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeProxyException
     */
    public function proxy(TypeApiDtoInterface $dto): TypeInterface;
//endregion Getters/Setters
}