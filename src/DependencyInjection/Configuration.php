<?php


namespace Evrinoma\CodeBundle\DependencyInjection;

use Evrinoma\CodeBundle\CodeBundle;
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
        $treeBuilder      = new TreeBuilder(CodeBundle::CODE_BUNDLE);
        $rootNode         = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
