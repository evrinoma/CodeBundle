<?php

namespace Evrinoma\CodeBundle\DependencyInjection\Compiler;


use Evrinoma\CodeBundle\EvrinomaCodeBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DecoratorPass extends AbstractRecursivePass
{
    private $servises = ['code', 'bunch', 'bind'];
//region SECTION: Public

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($this->servises as $alias) {
            $this->wireDecorates($container, $alias);
        }
    }

    private function wireDecorates(ContainerBuilder $container, string $name)
    {
        $decoratorQuery = $container->getParameter('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.decorates.'.$name.'.query');
        if ($decoratorQuery) {
            $queryMediator = $container->getDefinition($decoratorQuery);
            $repository    = $container->getDefinition('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.'.$name.'.repository');
            $repository->setArgument(2, $queryMediator);
        }
        $decoratorCommand = $container->getParameter('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.decorates.'.$name.'.command');
        if ($decoratorCommand) {
            $commandMediator = $container->getDefinition($decoratorCommand);
            $commandManager  = $container->getDefinition('evrinoma.'.EvrinomaCodeBundle::CODE_BUNDLE.'.'.$name.'.command.manager');
            $commandManager->setArgument(3, $commandMediator);
        }
    }
}