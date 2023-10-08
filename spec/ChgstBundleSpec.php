<?php

namespace spec\Chgst\ChgstBundle;

use Chgst\ChgstBundle\ChgstBundle;
use Chgst\ChgstBundle\DependencyInjection\ChgstExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChgstBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ChgstBundle::class);
        $this->shouldHaveType(Bundle::class);
    }

    function it_registers_compiler_passes(ContainerBuilder $builder)
    {
        $builder->addCompilerPass(Argument::any())->willReturn($builder);
        $this->build($builder);
    }

    function it_returns_extension()
    {
        $this->getContainerExtension()->shouldHaveType(ChgstExtension::class);
    }
}
