<?php

namespace Chgst\ChgstBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('chgst');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('event_repository')
                    ->defaultValue('@Chgst\Event\RepositoryInterface')
                ->end()
                ->scalarNode('event_bus')
                    ->defaultValue('@Chgst\Communication\EventBusInterface')
                ->end()
                ->scalarNode('command_handler')
                    ->defaultValue('@Chgst\Command\HandlerInterface')
                ->end()
                ->booleanNode('enable_listeners')
                    ->defaultFalse()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
