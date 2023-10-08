<?php

namespace Chgst\ChgstBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class ChgstExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yml');

        foreach($config as $key => $id)
        {
            if ( ! is_bool($id))
            {
                if(strpos(trim($id), '@') == 0) $id = substr($id, 1);

                if ($id)
                {
                    $container->setAlias(sprintf('Chgst.%s', $key), $id);
                }
            }
            else
            {
                $container->setParameter(sprintf('Chgst.%s', $key), $id);
            }
        }
    }
}