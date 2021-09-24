<?php


namespace Evrinoma\CodeBundle\DependencyInjection;

use Evrinoma\CodeBundle\Dto\BunchApiDto;
use Evrinoma\CodeBundle\Dto\CodeApiDto;
use Evrinoma\CodeBundle\Entity\Define\BaseOwner;
use Evrinoma\CodeBundle\Entity\Define\BaseType;
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
    public const ENTITY               = 'Evrinoma\CodeBundle\Entity';
    public const ENTITY_FACTORY_CODE  = 'Evrinoma\CodeBundle\Factory\CodeFactory';
    public const ENTITY_FACTORY_BUNCH = 'Evrinoma\CodeBundle\Factory\BunchFactory';
    public const ENTITY_BASE_CODE     = self::ENTITY.'\Code\BaseCode';
    public const ENTITY_BASE_BUNCH    = self::ENTITY.'\Bunch\BaseBunch';
    public const DTO_BASE_CODE        = CodeApiDto::class;
    public const DTO_BASE_BUNCH       = BunchApiDto::class;
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

        if ($config['factory_code'] !== self::ENTITY_FACTORY_CODE) {
            $this->wireFactory($container, 'code', $config['factory_code'], $config['entity_code']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.code.factory');
            $definitionFactory->setArgument(0, $config['entity_code']);
        }

        if ($config['factory_bunch'] !== self::ENTITY_FACTORY_CODE) {
            $this->wireFactory($container, 'bunch', $config['factory_bunch'], $config['entity_bunch']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.bunch.factory');
            $definitionFactory->setArgument(0, $config['entity_bunch']);
        }


        $doctrineRegistry = null;

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
            $doctrineRegistry = new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry');
            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);
            $objectManager = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $objectManager->setFactory([$doctrineRegistry, 'getManager']);
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

        if ($doctrineRegistry) {
            $this->wineRepository($container, $doctrineRegistry, 'type', BaseType::class);
            $this->wineRepository($container, $doctrineRegistry, 'owner', BaseOwner::class);
            $this->wineRepository($container, $doctrineRegistry, 'bunch', $config['entity_bunch']);
            $this->wineRepository($container, $doctrineRegistry, 'code', $config['entity_code']);
        }

        $this->wireController($container, 'bunch', $config['dto_bunch']);
        $this->wireController($container, 'code', $config['dto_code']);

        $this->wireValidator($container, 'bunch', $config['entity_bunch']);
        $this->wireValidator($container, 'code', $config['entity_code']);
    }
//endregion Public

//region SECTION: Private
    private function wireFactory(ContainerBuilder $container, string $name, string $class, string $paramClass)
    {
        $container->removeDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $definitionFactory = new Definition($class);
        $definitionFactory->addArgument($paramClass);
        $alias = new Alias('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.'.$name.'.factory' => $definitionFactory]);
        $container->addAliases([$class => $alias]);
    }


    private function wireController(ContainerBuilder $container, string $name, string $class)
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.api.controller');
        $definitionApiController->setArgument(5, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $name, string $class)
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.validator');
        $definitionApiController->setArgument(0, $class);
    }

    private function wineRepository(ContainerBuilder $container, Reference $doctrineRegistry, string $name, string $class): void
    {
        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.repository');

        switch ($name) {
            case 'code':
            case 'bunch':
                $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.query.mediator');
                $definitionRepository->setArgument(2, $definitionQueryMediator);
            case 'type':
            case 'owner':
                $definitionRepository->setArgument(1, $class);
            default:
                $definitionRepository->setArgument(0, $doctrineRegistry);
        }
        $array = $definitionRepository->getArguments();
        ksort($array);
        $definitionRepository->setArguments($array);

    }
//endregion Private

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaCodeBundle::CODE_BUNDLE;
    }
//endregion Getters/Setters
}