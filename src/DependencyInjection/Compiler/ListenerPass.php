<?php

namespace Changeset\ChangesetBundle\DependencyInjection\Compiler;

use Changeset\Communication\EventBusInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if( ! $container->has(EventBusInterface::class)) return;

        if( ! $container->getParameter('changeset.enable_listeners')) return;

        $definition = $container->findDefinition(EventBusInterface::class);

        $definition->addMethodCall('enableListeners');

        $taggedServices = $container->findTaggedServiceIds('changeset.event.listener');

        foreach ($taggedServices as $id => $tags)
        {
            $definition->addMethodCall('addListener', [ new Reference($id) ]);
        }
    }
}