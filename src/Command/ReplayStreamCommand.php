<?php

namespace Chgst\ChgstBundle\Command;

use Chgst\Communication\EventBusInterface;
use Chgst\Event\RepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class ReplayStreamCommand extends Command
{
    private RepositoryInterface $repository;

    private EventBusInterface $eventBus;

    private int $batchSize = 1000;

    public function __construct(RepositoryInterface $repository, EventBusInterface $eventBus, $batchSize = null)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;

        if($batchSize) $this->batchSize = $batchSize;

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('replay:stream')
            ->setDescription('Replays events for event store to trigger projectors')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->eventBus->disableListeners();
        $output->writeln('<fg=green>[chgst]</> Replaying all events in the event stream');

        $progressBar = new ProgressBar($output, $this->batchSize);
        $progressBar->setRedrawFrequency(intval($this->batchSize / 10));
        $progressBar->setBarWidth(100);
        $progressBar->start();

        $iterator = $this->repository->getIterator();

        $batchCounter = 0;
        $totalCounter = 0;

        foreach ($iterator as $event)
        {
            $this->eventBus->dispatch(is_array($event) ? $event[0] : $event);

            $totalCounter++;
            $progressBar->advance();

            if($progressBar->getProgress() >= $this->batchSize)
            {
                $batchCounter++;
                $progressBar->finish();
                $output->writeln(sprintf(' processed %d items', $batchCounter * $this->batchSize));
                $progressBar->start();
            }
        }

        $output->writeln(sprintf(' processed %d items', $totalCounter));
    }
}
