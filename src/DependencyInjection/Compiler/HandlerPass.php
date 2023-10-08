<?php

namespace Chgst\ChgstBundle\DependencyInjection\Compiler;

use Chgst\Communication\CommandBusInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class HandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if( ! $container->has(CommandBusInterface::class)) return;

        $definition = $container->findDefinition(CommandBusInterface::class);

        $definition->addMethodCall('setEventBus', [ new Reference('Chgst.event_bus' )]);
        $definition->addMethodCall('setHandler', [ new Reference('Chgst.command_handler' )]);
    }
}