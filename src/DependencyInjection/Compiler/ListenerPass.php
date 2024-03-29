<?php

namespace Chgst\ChgstBundle\DependencyInjection\Compiler;

use Chgst\Communication\EventBusInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if( ! $container->has(EventBusInterface::class)) return;

        if( ! $container->getParameter('chgst.enable_listeners')) return;

        $definition = $container->findDefinition(EventBusInterface::class);

        $definition->addMethodCall('enableListeners');

        $taggedServices = $container->findTaggedServiceIds('chgst.event.listener');

        foreach ($taggedServices as $id => $tags)
        {
            $definition->addMethodCall('addListener', [ new Reference($id), (isset($tags[0]['priority']) ? $tags[0]['priority'] : 0) ]);
        }
    }
}