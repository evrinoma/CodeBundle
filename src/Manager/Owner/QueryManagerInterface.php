<?php


namespace Evrinoma\CodeBundle\Manager\Owner;


use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Exception\Owner\OwnerProxyException;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;

interface QueryManagerInterface
{
//region SECTION: Public
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface[]
     * @throws OwnerNotFoundException
     */
    public function criteria(OwnerApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     * @throws OwnerNotFoundException
     */
    public function get(OwnerApiDtoInterface $dto): OwnerInterface;

    /**
     * @param OwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     * @throws OwnerProxyException
     */
    public function proxy(OwnerApiDtoInterface $dto): OwnerInterface;
//endregion Getters/Setters
}