<?php


namespace Evrinoma\CodeBundle\DependencyInjection;

use Evrinoma\CodeBundle\EvrinomaCodeBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Evrinoma\CodeBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaCodeBundle::CODE_BUNDLE);
        $rootNode    = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory_code')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::ENTITY_FACTORY_CODE)->end()
            ->scalarNode('factory_bunch')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::ENTITY_FACTORY_BUNCH)->end()
            ->scalarNode('entity_code')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::ENTITY_BASE_CODE)->end()
            ->scalarNode('entity_bunch')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::ENTITY_BASE_BUNCH)->end()
            ->scalarNode('constraints_code')->defaultTrue()->info('This option is used for enable/disable basic code constraints')->end()
            ->scalarNode('constraints_bunch')->defaultTrue()->info('This option is used for enable/disable basic bunch constraints')->end()
            ->scalarNode('dto_code')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::DTO_BASE_CODE)->info('This option is used for dto class override')->end()
            ->scalarNode('dto_bunch')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::DTO_BASE_BUNCH)->info('This option is used for dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used for command decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used for query decoration')->end()
            ->end()->end()->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
