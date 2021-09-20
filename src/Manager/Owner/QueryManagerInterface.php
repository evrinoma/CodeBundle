<?php


namespace Evrinoma\CodeBundle\Manager\Owner;


use Evrinoma\CodeBundle\Dto\CodeOwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Model\OwnerInterface;

interface QueryManagerInterface
{
    /**
     * @param CodeOwnerApiDtoInterface $dto
     *
     * @return OwnerInterface
     */
    public function get(CodeOwnerApiDtoInterface $dto): OwnerInterface;

    /**
     * @param CodeOwnerApiDtoInterface $dto
     *
     * @return OwnerInterface[]
     * @throws OwnerNotFoundException
     */
    public function criteria(CodeOwnerApiDtoInterface $dto): array;
}