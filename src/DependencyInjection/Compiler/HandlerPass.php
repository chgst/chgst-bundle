<?php

namespace Changeset\ChangesetBundle\DependencyInjection\Compiler;

use Changeset\Communication\CommandBusInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class HandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if( ! $container->has(CommandBusInterface::class)) return;

        $definition = $container->findDefinition(CommandBusInterface::class);

        $definition->addMethodCall('setEventBus', [ new Reference('changeset.event_bus' )]);
        $definition->addMethodCall('setHandler', [ new Reference('changeset.command_handler' )]);
    }
}