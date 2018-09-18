<?php

namespace spec\Changeset\ChangesetBundle\EventListener;

use Changeset\ChangesetBundle\EventListener\EventAppendSubscriber;
use Changeset\Common\BlameableInterface;
use Changeset\Common\TimestampableInterface;
use Changeset\Event\EventInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class EventAppendSubscriberSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $storage, TokenInterface $token)
    {
        $storage->getToken()->willReturn($token);

        $this->beConstructedWith($storage);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EventAppendSubscriber::class);
        $this->shouldHaveType(EventSubscriberInterface::class);
    }

    function it_implements_required_getSubscribedEvents_method()
    {
        $this->getSubscribedEvents()->shouldHaveCount(1);
    }

    function it_can_setBlame_on_event(GenericEvent $event, BlameableInterface $subject, TokenInterface $token)
    {
        $event->getSubject()->willReturn($subject);

        $subject->setCreatedBy(Argument::any())->shouldBeCalled();

        $token->getUsername()->willReturn('some username');

        $this->setBlame($event);
    }

    function it_can_setTimestamp_on_the_event(GenericEvent $event, TimestampableInterface $subject)
    {
        $event->getSubject()->willReturn($subject);

        $subject->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->setTimestamp($event);
    }
}
