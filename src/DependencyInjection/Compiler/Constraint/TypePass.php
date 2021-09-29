<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint;


use Evrinoma\CodeBundle\Validator\TypeValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TypePass extends AbstractConstraint implements CompilerPassInterface
{
    public const CODE_TYPE_CONSTRAINT = 'evrinoma.code.constraint.type';

    protected static string $alias = self::CODE_TYPE_CONSTRAINT;
    protected static string $class = TypeValidator::class;
    protected static string $methodCall = 'addConstraint';
}