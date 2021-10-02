<?php


namespace Evrinoma\CodeBundle\Constraint\Bind;

use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

final class Code implements ConstraintInterface
{
//region SECTION: Getters/Setters
    public function getConstraints(): array
    {
        return [
            new NotBlank(),
            new NotNull()
        ];
    }

    public function getPropertyName(): string
    {
        return 'bunch';
    }
//endregion Getters/Setters
}