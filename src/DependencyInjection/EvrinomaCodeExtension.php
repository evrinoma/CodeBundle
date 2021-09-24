<?php


namespace Evrinoma\CodeBundle\DependencyInjection;

use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\CodeBundle\EvrinomaCodeBundle;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class EvrinomaCodeExtension extends Extension
{
    use HelperTrait;

//region SECTION: Fields
    public const ENTITY            = 'Evrinoma\CodeBundle\Entity';
    public const ENTITY_FACTORY    = 'Evrinoma\CodeBundle\Factory\CodeFactory';
    public const ENTITY_BASE_CODE  = self::ENTITY.'\Basic\Code\BaseCode';
    public const ENTITY_BASE_BUNCH = self::ENTITY.'\Basic\Bunch\BaseBunch';

    /**
     * @var array
     */
    private static array $doctrineDrivers = array(
        'orm' => array(
            'registry' => 'doctrine',
            'tag'      => 'doctrine.event_subscriber',
        ),
    );
//endregion Fields

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
            $alias             = new Alias('evrinoma.'.$this->getAlias().'.factory');
            $container->addDefinitions(['evrinoma.'.$this->getAlias().'.factory' => $definitionFactory]);
            $container->addAliases([$config['factory'] => $alias]);
        }

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));


            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);

            $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $definitionRepository->setFactory([new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry'), 'getManager']);
        }

        $this->remapParametersNamespaces(
            $container,
            $config,
            [
                '' => [
                    'db_driver'    => 'evrinoma.'.$this->getAlias().'.storage',
                    'entity_bunch' => 'evrinoma.'.$this->getAlias().'.entity_bunch',
                    'entity_code'  => 'evrinoma.'.$this->getAlias().'.entity_code',
                ],
            ]
        );

    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaCodeBundle::CODE_BUNDLE;
    }
//endregion Getters/Setters
}