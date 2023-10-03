<?php

namespace Changeset\ChangesetBundle\EventListener;

use Changeset\Common\BlameableInterface;
use Changeset\Common\TimestampableInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\SecurityBundle\Security;

class EventAppendSubscriber implements EventSubscriberInterface
{

    protected string $userIdentifier;

    public function __construct(Security $security)
    {
        if ($user = $security->getUser())
        {
            $this->userIdentifier = $user->getUserIdentifier();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'changeset.command.handled' => [
                [ 'setBlame', 0 ],
                [ 'setTimestamp', 0 ]
            ]
        ];
    }

    public function setBlame(GenericEvent $event): void
    {
        if ($event->getSubject() instanceof BlameableInterface)
        {
            $event->getSubject()->setCreatedBy($this->userIdentifier);
        }
    }

    public function setTimestamp(GenericEvent $event): void
    {
        if ($event->getSubject() instanceof TimestampableInterface)
        {
            $event->getSubject()->setCreatedAt(new \DateTime());
        }
    }
}
