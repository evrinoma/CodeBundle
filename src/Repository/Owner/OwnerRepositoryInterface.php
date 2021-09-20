<?php

namespace Evrinoma\CodeBundle\Repository\Owner;

use Evrinoma\CodeBundle\Dto\OwnerApiDtoInterface;
use Evrinoma\CodeBundle\Exception\Owner\OwnerNotFoundException;

interface OwnerRepositoryInterface extends OwnerQueryRepositoryInterface, OwnerCommandRepositoryInterface
{
}