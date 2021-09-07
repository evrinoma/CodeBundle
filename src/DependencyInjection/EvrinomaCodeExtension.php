<?php


namespace Evrinoma\CodeBundle\DependencyInjection;

use Evrinoma\CodeBundle\EvrinomaCodeBundle;
use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class EvrinomaCodeExtension extends Extension
{
    public const ENTITY_FACTORY           = 'Evrinoma\CodeBundle\Factory\CodeFactory';
    public const ENTITY_BASE_CODE         = 'Evrinoma\CodeBundle\Entity\Basic\BaseCode';
    public const ENTITY_BASE_BUNCH        = 'Evrinoma\CodeBundle\Entity\Basic\BaseBunch';

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.api.controller');
        $definitionApiController->setArgument(5, $config['dto'] ?? CodeApiDto::class);

        if ($config['factory'] !== self::ENTITY_FACTORY) {
            $container->removeDefinition('evrinoma.'.$this->getAlias().'.factory');
            $definitionFactory = new Definition($config['factory']);
            $alias = new Alias('evrinoma.'.$this->getAlias().'.factory');
            $container->addDefinitions([ 'evrinoma.'.$this->getAlias().'.factory' => $definitionFactory]);
            $container->addAliases([$config['factory'] => $alias]);
        }


    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaCodeBundle::CODE_BUNDLE;
    }
//endregion Getters/Setters
}