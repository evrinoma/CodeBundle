<?php


namespace Evrinoma\CodeBundle\Constraint\Owner;

use Evrinoma\CodeBundle\Constraint\Common\DescriptionTrait;
use Evrinoma\UtilsBundle\Constraint\ConstraintInterface;

final class Description implements ConstraintInterface
{
    use DescriptionTrait;
}