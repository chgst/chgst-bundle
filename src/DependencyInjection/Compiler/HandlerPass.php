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

        $taggedServices = $container->findTaggedServiceIds('changeset.command.handler');

        foreach ($taggedServices as $id => $tags)
        {
            $definition->addMethodCall('addHandler', [ new Reference($id) ]);

            $container
                ->findDefinition($id)
                ->addMethodCall('setRepository', [ new Reference('changeset.event_repository') ]);
        }
    }
}