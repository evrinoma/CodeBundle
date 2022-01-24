<?php

namespace Evrinoma\CodeBundle\Constraint\Property\Common;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

trait TypeTrait
{
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
            new NotNull()
        ];
    }

    public function getPropertyName(): string
    {
        return 'type';
    }
}