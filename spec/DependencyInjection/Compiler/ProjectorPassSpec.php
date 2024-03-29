<?php

namespace spec\Chgst\ChgstBundle\DependencyInjection\Compiler;

use Chgst\ChgstBundle\DependencyInjection\Compiler\ProjectorPass;
use Chgst\Communication\EventBusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ProjectorPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectorPass::class);
        $this->shouldHaveType(CompilerPassInterface::class);
    }

    function it_registers_all_services_tagged_as_projector_to_event_bus(ContainerBuilder $builder, Definition $definition)
    {
        $builder->has(EventBusInterface::class)->willReturn(false);
        $this->process($builder);


        $builder->has(EventBusInterface::class)->willReturn(true);
        $builder->findDefinition(Argument::any())->willReturn($definition);

        $services = [ 'someId' => [ ['event' => 'some.event' ]]];

        $builder->findTaggedServiceIds('chgst.event.projector')->willReturn($services);
        $definition->addMethodCall(Argument::any(), Argument::any())->willReturn($definition);
        $this->process($builder);
    }
}
