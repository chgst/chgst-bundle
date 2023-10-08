<?php

namespace spec\Chgst\ChgstBundle\DependencyInjection;

use Chgst\ChgstBundle\DependencyInjection\Configuration;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Configuration::class);
        $this->shouldHaveType(ConfigurationInterface::class);
    }

    function it_requires_to_set_values_in_config_yml()
    {
        $this->getConfigTreeBuilder()->shouldReturnAnInstanceOf(TreeBuilder::class);
    }
}
