<?php

namespace Evrinoma\CodeBundle\Manager\Bind;

use Evrinoma\CodeBundle\Dto\BindApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Bind\BindCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Bind\BindInvalidException;
use Evrinoma\CodeBundle\Exception\Bind\BindNotFoundException;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;

interface CommandManagerInterface
{
//region SECTION: Public
    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindCannotBeSavedException
     * @throws BindInvalidException
     */
    public function put(BindApiDtoInterface $dto): BindInterface;

    /**
     * @param BindApiDtoInterface $dto
     *
     * @return BindInterface
     * @throws BindNotFoundException
     * @throws BindCannotBeSavedException
     * @throws BindInvalidException
     */
    public function post(BindApiDtoInterface $dto): BindInterface;

    /**
     * @param BindApiDtoInterface $dto
     *
     * @throws BindCannotBeRemovedException
     * @throws BindNotFoundException
     */
    public function delete(BindApiDtoInterface $dto): void;
//endregion Public

}