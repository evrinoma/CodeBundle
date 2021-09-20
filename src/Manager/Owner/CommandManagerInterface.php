<?php

namespace Evrinoma\CodeBundle\Manager\Owner;


use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Model\OwnerInterface;

interface CommandManagerInterface
{
    public function post(OwnerApiDtoInterface $dto): OwnerInterface;

    public function put(OwnerApiDtoInterface $dto): OwnerInterface;

    public function delete(OwnerApiDtoInterface $dto): void;
}