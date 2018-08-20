<?php

namespace Changeset\ChangesetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class ChangesetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->processConfiguration(new Configuration(), $configs);
    }
}