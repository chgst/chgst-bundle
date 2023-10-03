<?php

namespace spec\Changeset\ChangesetBundle\DependencyInjection\Compiler;

use Changeset\ChangesetBundle\DependencyInjection\Compiler\HandlerPass;
use Changeset\Communication\CommandBusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class HandlerPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HandlerPass::class);
        $this->shouldHaveType(CompilerPassInterface::class);
    }

    function it_registers_all_services_tagged_as_handler_to_command_bus(ContainerBuilder $builder, Definition $definition)
    {
        $builder->has(CommandBusInterface::class)->willReturn(false);
        $this->process($builder);


        $builder->has(CommandBusInterface::class)->willReturn(true);
        $builder->findDefinition(Argument::any())->willReturn($definition);

        $services = [ 'someId' => [ ['event' => 'some.event' ]]];

        $builder->findTaggedServiceIds('changeset.command.handler')->willReturn($services);
        $definition->addMethodCall(Argument::any(), Argument::any())->willReturn($definition);
        $this->process($builder);
    }
}
