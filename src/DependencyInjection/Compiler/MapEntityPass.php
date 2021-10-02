<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler;

use Evrinoma\CodeBundle\DependencyInjection\EvrinomaCodeExtension;
use Evrinoma\CodeBundle\Entity\Bind\BaseBind;
use Evrinoma\CodeBundle\Entity\Bunch\BaseBunch;
use Evrinoma\CodeBundle\Entity\Code\BaseCode;
use Evrinoma\CodeBundle\Entity\Define\BaseOwner;
use Evrinoma\CodeBundle\Entity\Define\BaseType;
use Evrinoma\CodeBundle\Model\Bind\BindInterface;
use Evrinoma\CodeBundle\Model\Bunch\BunchInterface;
use Evrinoma\CodeBundle\Model\Code\CodeInterface;
use Evrinoma\CodeBundle\Model\Define\OwnerInterface;
use Evrinoma\CodeBundle\Model\Define\TypeInterface;
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

        $this->cleanMetadata($driver, [EvrinomaCodeExtension::ENTITY]);

        /** load default entities*/
        $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Define', '%s/Entity/Define');
        $this->addResolveTargetEntity(
            [
                BaseOwner::class => OwnerInterface::class,
                BaseType::class  => TypeInterface::class,
            ],
            false
        );

        $entityBunch = $container->getParameter('evrinoma.code.entity_bunch');
        if ((strpos($entityBunch, EvrinomaCodeExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Bunch', '%s/Entity/Bunch');
            $this->addResolveTargetEntity([BaseBunch::class => BunchInterface::class,], false);
        }

        $entityCode = $container->getParameter('evrinoma.code.entity_code');

        if ((strpos($entityCode, EvrinomaCodeExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Code', '%s/Entity/Code');
            $this->addResolveTargetEntity([BaseCode::class => CodeInterface::class,], false);
        }

        $entityCode = $container->getParameter('evrinoma.code.entity_bind');

        if ((strpos($entityCode, EvrinomaCodeExtension::ENTITY) !== false)) {
            $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Bind', '%s/Entity/Bind');
            $this->addResolveTargetEntity([BaseBind::class => BindInterface::class,], false);
        }
    }


//endregion Private
}