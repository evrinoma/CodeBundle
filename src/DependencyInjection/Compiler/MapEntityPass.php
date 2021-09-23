<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler;

use Evrinoma\CodeBundle\DependencyInjection\EvrinomaCodeExtension;
use Evrinoma\CodeBundle\Entity\BaseBunch;
use Evrinoma\CodeBundle\Entity\BaseCode;
use Evrinoma\CodeBundle\Entity\BaseOwner;
use Evrinoma\CodeBundle\Entity\BaseType;
use Evrinoma\CodeBundle\Model\BunchInterface;
use Evrinoma\CodeBundle\Model\CodeInterface;
use Evrinoma\CodeBundle\Model\OwnerInterface;
use Evrinoma\CodeBundle\Model\TypeInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $this->setContainer($container);

        $driver                    = $container->findDefinition('doctrine.orm.default_metadata_driver');
        $referenceAnnotationReader = new Reference('annotations.reader');

        $entityBunch = $container->getParameter('evrinoma.code.entity_code');
        $entityCode  = $container->getParameter('evrinoma.code.entity_bunch');
        if ((strpos($entityBunch, EvrinomaCodeExtension::ENTITY) !== false) && (strpos($entityCode, EvrinomaCodeExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model', '%s/Entity');
            $this->addResolveTargetEntity(
                [
                    BaseCode::class  => CodeInterface::class,
                    BaseBunch::class => BunchInterface::class,
                    BaseOwner::class => OwnerInterface::class,
                    BaseType::class  => TypeInterface::class,
                ],
                false
            );

        } else {
            $this->cleanMetadata($driver, [EvrinomaCodeExtension::ENTITY]);
        }
    }

//endregion Private
}