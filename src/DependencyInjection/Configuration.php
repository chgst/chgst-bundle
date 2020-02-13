<?php

namespace Changeset\ChangesetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('changeset');

        if ( ! method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->root('changeset');
        }
        else {
            $rootNode = $treeBuilder->getRootNode();
        }

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('event_repository')
                    ->defaultValue('@Changeset\Event\RepositoryInterface')
                ->end()
                ->scalarNode('event_bus')
                    ->defaultValue('@Changeset\Communication\EventBusInterface')
                ->end()
                ->scalarNode('command_handler')
                    ->defaultValue('@Changeset\Command\HandlerInterface')
                ->end()
                ->booleanNode('enable_listeners')
                    ->defaultFalse()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
