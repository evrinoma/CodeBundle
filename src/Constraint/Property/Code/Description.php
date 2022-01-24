<?php


namespace Evrinoma\CodeBundle\Constraint\Property\Code;

use Evrinoma\CodeBundle\Constraint\Property\Common\DescriptionTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Description implements ConstraintInterface
{
    use DescriptionTrait;
}