<?php

namespace Changeset\ChangesetBundle\Command;

use Changeset\Communication\EventBusInterface;
use Changeset\Event\RepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReplayStreamCommand extends Command
{
    /** @var RepositoryInterface */
    private $repository;

    /** @var EventBusInterface */
    private $eventBus;

    /**
     * ReplayStreamCommand constructor.
     *
     * @param RepositoryInterface $repository
     * @param EventBusInterface $eventBus
     */
    public function __construct(RepositoryInterface $repository, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('replay:stream')
            ->setDescription('Replays events for event store to trigger projectors')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $iterator = $this->repository->getIterator();

        foreach ($iterator as $event)
        {
            $this->eventBus->dispatch($event);
        }
    }
}
