<?php

namespace Evrinoma\CodeBundle\Manager\Type;

use Evrinoma\CodeBundle\Dto\TypeApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Type\TypeCannotBeRemovedException;
use Evrinoma\Codebundle\Exception\Type\TypeInvalidException;
use Evrinoma\Codebundle\Exception\Type\TypeNotFoundException;
use Evrinoma\CodeBundle\Model\TypeInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeInvalidException
     */
    public function post(TypeApiDtoInterface $dto): TypeInterface;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @return TypeInterface
     * @throws TypeInvalidException
     * @throws TypeNotFoundException
     */
    public function put(TypeApiDtoInterface $dto): TypeInterface;

    /**
     * @param TypeApiDtoInterface $dto
     *
     * @throws TypeCannotBeRemovedException
     * @throws TypeNotFoundException
     */
    public function delete(TypeApiDtoInterface $dto): void;
//endregion Public
}