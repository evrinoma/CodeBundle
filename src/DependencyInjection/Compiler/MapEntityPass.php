<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Evrinoma\CodeBundle\DependencyInjection\EvrinomaCodeExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass implements CompilerPassInterface
{
//region SECTION: Fields
    private string $nameSpace;
    private string $path;
//endregion Fields
//region SECTION: Constructor
    /**
     * MapEntityPass constructor.
     *
     * @param string $nameSpace
     */
    public function __construct(string $nameSpace, string $path)
    {
        $this->nameSpace = $nameSpace;
        $this->path      = $path;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $driver                    = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $this->loadMetadata($container, $driver, $referenceAnnotationReader, '%s/Model/Basic', '%s/Entity/Basic');
        $this->remapEntity($driver, 'Basic');
    }

//region SECTION: Private
    private function loadMetadata(ContainerBuilder $container, Definition $driver, Reference $referenceAnnotationReader, $formatterModel, $formatterEntity): void
    {
        $definitionAnnotationDriver = new Definition(AnnotationDriver::class, [$referenceAnnotationReader, sprintf($formatterModel, $this->path)]);
        $driver->addMethodCall('addDriver', [$definitionAnnotationDriver, sprintf(str_replace('/', '\\', $formatterModel), $this->nameSpace)]);

        if (in_array($container->getParameter('evrinoma.code.entity'), [EvrinomaCodeExtension::ENTITY_BASE_BUNCH, EvrinomaCodeExtension::ENTITY_BASE_CODE], true)) {
            $definitionAnnotationDriver = new Definition(AnnotationDriver::class, [$referenceAnnotationReader, sprintf($formatterEntity, $this->path)]);
            $driver->addMethodCall('addDriver', [$definitionAnnotationDriver, sprintf(str_replace('/', '\\', $formatterEntity), $this->nameSpace)]);
        }
    }

    private function remapEntity(Definition $driver, string $mapFolder): void
    {
        $calls = [];
        foreach ($driver->getMethodCalls() as $i => $call) {
            if ($call[1][1] && $call[1][1] === 'Evrinoma\CodeBundle\Entity') {
                $call[1][1] = 'Evrinoma\CodeBundle\Entity\\'.$mapFolder;
            }
            $calls[] = $call;
        }
        $driver->setMethodCalls($calls);
    }
//endregion Private
}