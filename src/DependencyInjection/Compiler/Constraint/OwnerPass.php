<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint;


use Evrinoma\CodeBundle\Validator\OwnerValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class OwnerPass extends AbstractConstraint implements CompilerPassInterface
{
    public const CODE_OWNER_CONSTRAINT = 'evrinoma.code.constraint.owner';

    protected static string $alias = self::CODE_OWNER_CONSTRAINT;
    protected static string $class = OwnerValidator::class;
    protected static string $methodCall = 'addConstraint';
}