<?php

namespace Evrinoma\CodeBundle\Constraint\Property\Common;

use Symfony\Component\Validator\Constraints\NotBlank;

trait BriefTrait
{
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'brief';
    }
}