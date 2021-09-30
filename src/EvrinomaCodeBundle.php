<?php


namespace Evrinoma\CodeBundle;

use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\BunchPass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\CodePass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\OwnerPass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\TypePass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\CodeBundle\DependencyInjection\EvrinomaCodeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 * Class CodeBundle
 *
 * @package Evrinoma\CodeBundle
 */
class EvrinomaCodeBundle extends Bundle
{
//region SECTION: Fields
    public const CODE_BUNDLE = 'code';
//endregion Fields

//region SECTION: Public
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new TypePass())
            ->addCompilerPass(new OwnerPass())
            ->addCompilerPass(new BunchPass())
            ->addCompilerPass(new CodePass())
            ->addCompilerPass(new DecoratorPass())
        ;
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaCodeExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}