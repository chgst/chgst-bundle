<?php

namespace spec\Changeset\ChangesetBundle\DependencyInjection\Compiler;

use Changeset\ChangesetBundle\DependencyInjection\Compiler\ListenerPass;
use Changeset\Communication\EventBusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ListenerPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ListenerPass::class);
        $this->shouldHaveType(CompilerPassInterface::class);
    }

    function it_registers_all_services_tagged_as_listener_to_event_bus(ContainerBuilder $builder, Definition $definition)
    {
        $builder->has(EventBusInterface::class)->willReturn(false);
        $this->process($builder);


        $builder->has(EventBusInterface::class)->willReturn(true);
        $builder->findDefinition(Argument::any())->willReturn($definition);

        $services = [ 'someId' => [ ['event' => 'some.event' ]]];

        $builder->findTaggedServiceIds('changeset.event.listener')->willReturn($services);
        $definition->addMethodCall(Argument::any(), Argument::any())->shouldBeCalled();
        $this->process($builder);
    }
}
