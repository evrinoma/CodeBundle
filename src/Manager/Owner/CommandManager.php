<?php

namespace Evrinoma\CodeBundle\Manager\Owner;

use Evrinoma\CodeBundle\Dto\CodeOwnerApiDtoInterface;
use Evrinoma\CodeBundle\Model\OwnerInterface;
use Evrinoma\ContractorBundle\Dto\ContractorApiDtoInterface;
use Evrinoma\ContractorBundle\Model\Basic\ContractorInterface;

final class CommandManager implements CommandManagerInterface
{

    public function post(CodeOwnerApiDtoInterface $dto): OwnerInterface
    {
        // TODO: Implement post() method.
    }

    public function put(CodeOwnerApiDtoInterface $dto): OwnerInterface
    {
        // TODO: Implement put() method.
    }

    public function delete(CodeOwnerApiDtoInterface $dto): void
    {
        // TODO: Implement delete() method.
    }
}