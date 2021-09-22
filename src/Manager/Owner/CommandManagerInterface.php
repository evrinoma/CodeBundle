<?php

namespace Evrinoma\CodeBundle\Manager\Owner;


use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeRemovedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerCannotBeSavedException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerInvalidException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Model\OwnerInterface;

interface CommandManagerInterface
{
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     * @throws OwnerCannotBeSavedException
     * @throws OwnerInvalidException
     */
    public function post(OwnerApiDtoInterface $dto): OwnerInterface;
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     * @throws OwnerInvalidException
     * @throws OwnerNotFoundException
     * @throws OwnerCannotBeSavedException
     */
    public function put(OwnerApiDtoInterface $dto): OwnerInterface;
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @throws OwnerCannotBeRemovedException
     * @throws OwnerNotFoundException
     */
    public function delete(OwnerApiDtoInterface $dto): void;
}