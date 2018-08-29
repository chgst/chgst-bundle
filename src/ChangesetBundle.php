<?php

namespace Changeset\ChangesetBundle;

use Changeset\ChangesetBundle\DependencyInjection\Compiler\HandlerPass;
use Changeset\ChangesetBundle\DependencyInjection\Compiler\ListenerPass;
use Changeset\ChangesetBundle\DependencyInjection\Compiler\ProjectorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChangesetBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new HandlerPass());
        $container->addCompilerPass(new ListenerPass());
        $container->addCompilerPass(new ProjectorPass());
    }
}
