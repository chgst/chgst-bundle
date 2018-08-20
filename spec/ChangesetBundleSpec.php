<?php

namespace spec\Changeset\ChangesetBundle;

use Changeset\ChangesetBundle\ChangesetBundle;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChangesetBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ChangesetBundle::class);
        $this->shouldHaveType(Bundle::class);
    }
}
