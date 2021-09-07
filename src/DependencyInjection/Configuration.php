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
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::ENTITY_FACTORY)->end()
            ->scalarNode('entity_code')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::ENTITY_BASE_CODE)->end()
            ->scalarNode('entity_bunch')->cannotBeEmpty()->defaultValue(EvrinomaCodeExtension::ENTITY_BASE_BUNCH)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used for enable/disable basic constraints')->end()
            ->scalarNode('dto')->defaultNull()->info('This option is used for dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used for command decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used for query decoration')->end()
            ->end()->end()->end();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
