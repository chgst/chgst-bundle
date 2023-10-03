<?php

namespace spec\Changeset\ChangesetBundle\Command;

use Changeset\ChangesetBundle\Command\ReplayStreamCommand;
use Changeset\Communication\EventBusInterface;
use Changeset\Event\EventInterface;
use Changeset\Event\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReplayStreamCommandSpec extends ObjectBehavior
{
    function let(RepositoryInterface $repository, EventBusInterface $eventBus)
    {
        $this->beConstructedWith($repository, $eventBus, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ReplayStreamCommand::class);
        $this->shouldHaveType(Command::class);
    }

    function it_can_replay_all_messages(
        InputInterface $input,
        OutputInterface $output,
        RepositoryInterface $repository,
        EventBusInterface $eventBus,
        \Iterator $iterator,
        EventInterface $event,
        OutputFormatterInterface $outputFormatter
    )
    {
        $repository->getIterator()->willReturn($iterator);

        $iterator->rewind()->shouldBeCalled();
        $iterator->next()->shouldBeCalled();
        $iterator->valid()->shouldBeCalled()->willReturn(true, false);
        $iterator->current()->willReturn($event);

        $output->isDecorated()->willReturn(false);
        $output->getFormatter()->willReturn($outputFormatter);
        $output->writeln(Argument::any())->shouldBeCalled();
        $output->write(Argument::any())->shouldBeCalled();
        $output->getVerbosity()->shouldBeCalled();

        $outputFormatter->isDecorated()->willReturn(false);
        $outputFormatter->setDecorated(false)->shouldBeCalled();
        $outputFormatter->format(Argument::any())->shouldBeCalled();

        $eventBus->disableListeners()->shouldBeCalled();
        $eventBus->dispatch(Argument::any())->shouldBeCalled();

        $this->execute($input, $output);
    }
}
