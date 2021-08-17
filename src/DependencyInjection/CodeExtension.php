<?php


namespace Evrinoma\CodeBundle\DependencyInjection;

use Evrinoma\CodeBundle\CodeBundle;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\ConstraintPass;
use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CodeExtension
 *
 * @package Evrinoma\CodeBundle\DependencyInjection
 */
class CodeExtension extends Extension
{
//region SECTION: Fields
//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return CodeBundle::CODE_BUNDLE;
    }
//endregion Getters/Setters
}