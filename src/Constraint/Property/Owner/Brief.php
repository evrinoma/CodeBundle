<?php


namespace Evrinoma\CodeBundle\Constraint\Property\Owner;

use Evrinoma\CodeBundle\Constraint\Property\Common\BriefTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

final class Brief implements ConstraintInterface
{
    use BriefTrait;
}