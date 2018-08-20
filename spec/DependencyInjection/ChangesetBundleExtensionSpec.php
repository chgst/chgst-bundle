<?php

namespace spec\Changeset\ChangesetBundle\DependencyInjection;

use Changeset\ChangesetBundle\DependencyInjection\ChangesetBundleExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class ChangesetBundleExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ChangesetBundleExtension::class);
        $this->shouldHaveType(Extension::class);
    }

    function it_processes_configuration(ContainerBuilder $container)
    {
        $this->load(['chgst_bundle' => ['event_repository' => '@defined']], $container);
    }
}
