<?php

namespace Chgst\ChgstBundle;

use Chgst\ChgstBundle\DependencyInjection\ChgstExtension;
use Chgst\ChgstBundle\DependencyInjection\Compiler\HandlerPass;
use Chgst\ChgstBundle\DependencyInjection\Compiler\ListenerPass;
use Chgst\ChgstBundle\DependencyInjection\Compiler\ProjectorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class ChgstBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new HandlerPass());
        $container->addCompilerPass(new ListenerPass());
        $container->addCompilerPass(new ProjectorPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ChgstExtension();
    }
}
