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


        $entityBunch = $container->getParameter('evrinoma.code.entity_code');
        $entityCode  = $container->getParameter('evrinoma.code.entity_bunch');
        if ((strpos($entityBunch, EvrinomaCodeExtension::ENTITY) !== false) && (strpos($entityCode, EvrinomaCodeExtension::ENTITY) !== false)) {
            $this->loadMetadata($container, $driver, $referenceAnnotationReader, '%s/Model', '%s/Entity');
        } else {
            $this->cleanMetadata($driver, [EvrinomaCodeExtension::ENTITY]);
        }
    }

//region SECTION: Private
    private function loadMetadata(ContainerBuilder $container, Definition $driver, Reference $referenceAnnotationReader, $formatterModel, $formatterEntity): void
    {
        $definitionAnnotationDriver = new Definition(AnnotationDriver::class, [$referenceAnnotationReader, sprintf($formatterModel, $this->path)]);
        $driver->addMethodCall('addDriver', [$definitionAnnotationDriver, sprintf(str_replace('/', '\\', $formatterModel), $this->nameSpace)]);
    }

    private function cleanMetadata(Definition $driver, array $namesSpaces)
    {
        $calls = [];
        foreach ($driver->getMethodCalls() as $i => $call) {
            if ($call[1][1] && in_array($call[1][1], $namesSpaces)) {
                continue;
            }
            $calls[] = $call;
        }
        $driver->setMethodCalls($calls);
    }
//endregion Private
}