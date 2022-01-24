<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property;


use Evrinoma\CodeBundle\Validator\TypeValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TypePass extends AbstractConstraint implements CompilerPassInterface
{
    public const CODE_TYPE_CONSTRAINT = 'evrinoma.code.constraint.type.property';

    protected static string $alias      = self::CODE_TYPE_CONSTRAINT;
    protected static string $class      = TypeValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}