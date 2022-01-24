<?php


namespace Evrinoma\CodeBundle\Constraint\Bunch;

use Evrinoma\CodeBundle\Constraint\Common\DescriptionTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Description implements ConstraintInterface
{
    use DescriptionTrait;
}