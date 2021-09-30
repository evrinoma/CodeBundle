<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler;


use Evrinoma\CodeBundle\EvrinomaCodeBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{
//region SECTION: Public
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.decorates.code.query');
        if ($decoratorQuery) {
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository    = $container->getDefinition('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.code.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.decorates.code.command');
        if ($decoratorCommand) {
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager  = $container->getDefinition('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.code.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }

        $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.decorates.bunch.query');
        if ($decoratorQuery) {
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository    = $container->getDefinition('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.bunch.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.decorates.bunch.command');
        if ($decoratorCommand) {
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager  = $container->getDefinition('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.bunch.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }
    }
}