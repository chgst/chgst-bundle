<?php

namespace Chgst\ChgstBundle\DependencyInjection\Compiler;

use Chgst\Communication\EventBusInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProjectorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if( ! $container->has(EventBusInterface::class)) return;

        $definition = $container->findDefinition(EventBusInterface::class);

        $taggedServices = $container->findTaggedServiceIds('Chgst.event.projector');

        foreach ($taggedServices as $id => $tags)
        {
            $definition->addMethodCall('addProjector', [ new Reference($id), (isset($tags[0]['priority']) ? $tags[0]['priority'] : 0) ]);
        }
    }
}