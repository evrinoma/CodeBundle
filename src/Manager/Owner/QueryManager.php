<?php

namespace Evrinoma\CodeBundle\Manager\Owner;

use Evrinoma\CodeBundle\Dto\CodeOwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;
use Evrinoma\CodeBundle\Model\OwnerInterface;

final class QueryManager implements QueryManagerInterface
{

    public function get(CodeOwnerApiDtoInterface $dto): OwnerInterface
    {
        // TODO: Implement get() method.
    }

    public function criteria(CodeOwnerApiDtoInterface $dto): array
    {
        // TODO: Implement criteria() method.
    }
}