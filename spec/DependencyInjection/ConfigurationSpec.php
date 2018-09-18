<?php

namespace spec\Changeset\ChangesetBundle\DependencyInjection;

use Changeset\ChangesetBundle\DependencyInjection\Configuration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
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
