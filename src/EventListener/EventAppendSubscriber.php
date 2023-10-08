<?php

namespace Chgst\ChgstBundle\EventListener;

use Chgst\Common\BlameableInterface;
use Chgst\Common\TimestampableInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\SecurityBundle\Security;

class EventAppendSubscriber implements EventSubscriberInterface
{

    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'chgst.command.handled' => [
                [ 'setBlame', 0 ],
                [ 'setTimestamp', 0 ]
            ]
        ];
    }

    public function setBlame(GenericEvent $event): void
    {
        $user = $this->security->getUser();

        if ($user && $event->getSubject() instanceof BlameableInterface)
        {
            $event->getSubject()->setCreatedBy($user->getUserIdentifier());
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
