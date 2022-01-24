<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property;


use Evrinoma\CodeBundle\Validator\CodeValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class CodePass extends AbstractConstraint implements CompilerPassInterface
{
    public const CODE_CODE_CONSTRAINT = 'evrinoma.code.constraint.code.property';

    protected static string $alias      = self::CODE_CODE_CONSTRAINT;
    protected static string $class      = CodeValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}