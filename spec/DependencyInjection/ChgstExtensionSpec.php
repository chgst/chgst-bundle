<?php

namespace spec\Chgst\ChgstBundle\DependencyInjection;

use Chgst\ChgstBundle\DependencyInjection\ChgstExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class ChgstExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ChgstExtension::class);
        $this->shouldHaveType(Extension::class);
    }

    function it_processes_configuration(ContainerBuilder $container)
    {
        $container->fileExists(Argument::any())->willReturn(true);
        $container->setDefinition(Argument::any(), Argument::any())->shouldBeCalled();
        $container->setAlias(Argument::any(), Argument::any())->shouldBeCalled();
        $container->setParameter(Argument::any(), Argument::any())->shouldBeCalled();
        $container->removeBindings(Argument::any())->shouldBeCalled();

        $this->load([ ['event_repository' => '@defined', 'event_bus' => '@also.defined'] ], $container);
    }
}
