<?php

namespace Changeset\ChangesetBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class ChangesetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->processConfiguration(new Configuration(), $configs);

        $id = $configs[0]['event_repository'];

        if(strpos(trim($id), '@') == 0) $id = substr($id, 1);

        $container->setAlias('changeset.event_repository', $id);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yml');
    }
}