<?php


namespace Evrinoma\CodeBundle\DependencyInjection;

use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property\BindPass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property\BunchPass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property\CodePass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property\OwnerPass;
use Evrinoma\CodeBundle\DependencyInjection\Compiler\Constraint\Property\TypePass;
use Evrinoma\CodeBundle\Dto\BindApiDto;
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
    public const ENTITY            = 'Evrinoma\CodeBundle\Entity';
    public const FACTORY_CODE      = 'Evrinoma\CodeBundle\Factory\CodeFactory';
    public const FACTORY_BUNCH     = 'Evrinoma\CodeBundle\Factory\BunchFactory';
    public const FACTORY_BIND      = 'Evrinoma\CodeBundle\Factory\BindFactory';
    public const ENTITY_BASE_CODE  = self::ENTITY.'\Code\BaseCode';
    public const ENTITY_BASE_BUNCH = self::ENTITY.'\Bunch\BaseBunch';
    public const ENTITY_BASE_BIND  = self::ENTITY.'\Bind\BaseBind';
    public const DTO_BASE_CODE     = CodeApiDto::class;
    public const DTO_BASE_BUNCH    = BunchApiDto::class;
    public const DTO_BASE_BIND     = BindApiDto::class;
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

        if ($container->getParameter('kernel.environment') !== 'prod') {
            $loader->load('fixtures.yml');
        }

        if ($container->getParameter('kernel.environment') === 'test') {
            $loader->load('tests.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        if ($config['factory_code'] !== self::FACTORY_CODE) {
            $this->wireFactory($container, 'code', $config['factory_code'], $config['entity_code']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.code.factory');
            $definitionFactory->setArgument(0, $config['entity_code']);
        }

        if ($config['factory_bunch'] !== self::FACTORY_BUNCH) {
            $this->wireFactory($container, 'bunch', $config['factory_bunch'], $config['entity_bunch']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.bunch.factory');
            $definitionFactory->setArgument(0, $config['entity_bunch']);
        }

        if ($config['factory_bind'] !== self::FACTORY_BIND) {
            $this->wireFactory($container, 'bind', $config['factory_bind'], $config['entity_bind']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.bind.factory');
            $definitionFactory->setArgument(0, $config['entity_bind']);
        }


        $registry = null;

        if (isset(self::$doctrineDrivers[$config['db_driver']]) && 'orm' === $config['db_driver']) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
            $registry = new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry');
            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);
            $objectManager = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $objectManager->setFactory([$registry, 'getManager']);
        }

        $this->remapParametersNamespaces(
            $container,
            $config,
            [
                '' => [
                    'db_driver'    => 'evrinoma.'.$this->getAlias().'.storage',
                    'entity_bunch' => 'evrinoma.'.$this->getAlias().'.entity_bunch',
                    'entity_code'  => 'evrinoma.'.$this->getAlias().'.entity_code',
                    'entity_bind'  => 'evrinoma.'.$this->getAlias().'.entity_bind',
                ],
            ]
        );

        if ($registry) {
            $this->wireRepository($container, $registry, 'type', BaseType::class);
            $this->wireRepository($container, $registry, 'owner', BaseOwner::class);
            $this->wireRepository($container, $registry, 'bunch', $config['entity_bunch']);
            $this->wireRepository($container, $registry, 'code', $config['entity_code']);
            $this->wireRepository($container, $registry, 'bind', $config['entity_bind']);
        }

        $this->wireController($container, 'bunch', $config['dto_bunch']);
        $this->wireController($container, 'code', $config['dto_code']);
        $this->wireController($container, 'bind', $config['dto_bind']);

        $this->wireForm($container, 'code', $config['dto_code']);
        $this->wireForm($container, 'bunch', $config['dto_bunch']);

        $this->wireValidator($container, 'bunch', $config['entity_bunch']);
        $this->wireValidator($container, 'code', $config['entity_code']);
        $this->wireValidator($container, 'bind', $config['entity_bind']);

        $loader->load('validation.yml');

        if ($config['constraints_bunch']) {
            $loader->load('constraint/bunch.yml');
        }

        if ($config['constraints_code']) {
            $loader->load('constraint/code.yml');
        }

        if ($config['constraints_bind']) {
            $loader->load('constraint/bind.yml');
        }

        $this->wireConstraintTag($container);

        if ($config['decorates']) {
            $this->remapParametersNamespaces(
                $container,
                $config['decorates'],
                [
                    '' => [
                        'command_code'  => 'evrinoma.'.$this->getAlias().'.decorates.code.command',
                        'query_code'    => 'evrinoma.'.$this->getAlias().'.decorates.code.query',
                        'command_bunch' => 'evrinoma.'.$this->getAlias().'.decorates.bunch.command',
                        'query_bunch'   => 'evrinoma.'.$this->getAlias().'.decorates.bunch.query',
                        'command_bind'  => 'evrinoma.'.$this->getAlias().'.decorates.bind.command',
                        'query_bind'    => 'evrinoma.'.$this->getAlias().'.decorates.bind.query',
                    ],
                ]
            );
        }
    }
//endregion Public

//region SECTION: Private

    private function wireConstraintTag(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $key => $definition) {
            switch (true) {
                case strpos($key, TypePass::CODE_TYPE_CONSTRAINT) !== false :
                    $definition->addTag(TypePass::CODE_TYPE_CONSTRAINT);
                    break;
                case strpos($key, OwnerPass::CODE_OWNER_CONSTRAINT) !== false :
                    $definition->addTag(OwnerPass::CODE_OWNER_CONSTRAINT);
                    break;
                case strpos($key, BunchPass::CODE_BUNCH_CONSTRAINT) !== false :
                    $definition->addTag(BunchPass::CODE_BUNCH_CONSTRAINT);
                    break;
                case strpos($key, CodePass::CODE_CODE_CONSTRAINT) !== false :
                    $definition->addTag(CodePass::CODE_CODE_CONSTRAINT);
                    break;
                case strpos($key, BindPass::CODE_BIND_CONSTRAINT) !== false :
                    $definition->addTag(BindPass::CODE_BIND_CONSTRAINT);
                    break;
            }
        }
    }

    private function wireFactory(ContainerBuilder $container, string $name, string $class, string $paramClass): void
    {
        $container->removeDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $definitionFactory = new Definition($class);
        $definitionFactory->addArgument($paramClass);
        $alias = new Alias('evrinoma.'.$this->getAlias().'.'.$name.'.factory');
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.'.$name.'.factory' => $definitionFactory]);
        $container->addAliases([$class => $alias]);
    }


    private function wireController(ContainerBuilder $container, string $name, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.api.controller');
        $definitionApiController->setArgument(5, $class);
    }


    private function wireForm(ContainerBuilder $container, string $name, string $class): void
    {
        $definitionForm = $container->getDefinition('evrinoma.'.$this->getAlias().'.form.rest.'.$name);
        $definitionForm->setArgument(1, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $name, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.validator');
        $definitionApiController->setArgument(0, new Reference('validator'));
        $definitionApiController->setArgument(1, $class);
    }

    private function wireRepository(ContainerBuilder $container, Reference $registry, string $name, string $class): void
    {
        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.repository');

        switch ($name) {
            case 'bind':
            case 'code':
            case 'bunch':
                $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.query.mediator');
                $definitionRepository->setArgument(2, $definitionQueryMediator);
            case 'type':
            case 'owner':
                $definitionRepository->setArgument(1, $class);
            default:
                $definitionRepository->setArgument(0, $registry);
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