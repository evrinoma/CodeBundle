<?php

namespace Evrinoma\CodeBundle\Manager\Owner;


use Evrinoma\CodeBundle\Dto\CodeOwnerApiDtoInterface;
use Evrinoma\CodeBundle\Model\OwnerInterface;

interface CommandManagerInterface
{
    public function post(CodeOwnerApiDtoInterface $dto): OwnerInterface;

    public function put(CodeOwnerApiDtoInterface $dto): OwnerInterface;

    public function delete(CodeOwnerApiDtoInterface $dto): void;
}