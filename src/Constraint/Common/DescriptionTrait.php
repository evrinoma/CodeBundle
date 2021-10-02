<?php

namespace Evrinoma\CodeBundle\Constraint\Common;

use Symfony\Component\Validator\Constraints\NotBlank;

trait DescriptionTrait
{
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'description';
    }
}