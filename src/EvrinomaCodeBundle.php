<?php


namespace Evrinoma\CodeBundle;

use Evrinoma\CodeBundle\DependencyInjection\Compiler\PassMapEntity;
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

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new PassMapEntity($this->getNamespace(), $this->getPath()))
        ;
    }
//endregion Fields

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