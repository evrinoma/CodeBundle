<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property;


use Evrinoma\CodeBundle\Validator\BindValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class BindPass extends AbstractConstraint implements CompilerPassInterface
{
    public const CODE_BIND_CONSTRAINT = 'evrinoma.code.constraint.bind.property';

    protected static string $alias      = self::CODE_BIND_CONSTRAINT;
    protected static string $class      = BindValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}