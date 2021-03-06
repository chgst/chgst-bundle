<?php

namespace Changeset\ChangesetBundle\EventListener;

use Changeset\Common\BlameableInterface;
use Changeset\Common\TimestampableInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EventAppendSubscriber implements EventSubscriberInterface
{
    /** @var string */
    protected $username;

    /**
     * EventAppendSubscriber constructor.
     *
     * @param TokenStorageInterface $storage
     */
    public function __construct(TokenStorageInterface $storage)
    {
        if ($storage->getToken() && $storage->getToken()->getUsername())
        {
            $this->username = $storage->getToken()->getUsername();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'changeset.command.handled' => [  [ 'setBlame', 0 ], [ 'setTimestamp', 0 ] ]
        ];
    }

    public function setBlame(GenericEvent $event)
    {
        if ($event->getSubject() instanceof BlameableInterface)
        {
            $event->getSubject()->setCreatedBy($this->username);
        }
    }

    public function setTimestamp(GenericEvent $event)
    {
        if ($event->getSubject() instanceof TimestampableInterface)
        {
            $event->getSubject()->setCreatedAt(new \DateTime());
        }
    }
}
