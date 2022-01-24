<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property;


use Evrinoma\CodeBundle\Validator\BunchValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class BunchPass extends AbstractConstraint implements CompilerPassInterface
{
    public const CODE_BUNCH_CONSTRAINT = 'evrinoma.code.constraint.bunch.property';

    protected static string $alias      = self::CODE_BUNCH_CONSTRAINT;
    protected static string $class      = BunchValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}