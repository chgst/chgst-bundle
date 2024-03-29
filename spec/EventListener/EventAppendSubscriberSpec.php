<?php

namespace spec\Chgst\ChgstBundle\EventListener;

use Chgst\ChgstBundle\EventListener\EventAppendSubscriber;
use Chgst\Common\BlameableInterface;
use Chgst\Common\TimestampableInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class EventAppendSubscriberSpec extends ObjectBehavior
{
    function let(Security $security, UserInterface $user)
    {
        $security->getUser()->willReturn($user);
        $user->getUserIdentifier()->willReturn('some username');

        $this->beConstructedWith($security);
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

    function it_can_setBlame_on_event(GenericEvent $event, BlameableInterface $subject)
    {
        $event->getSubject()->willReturn($subject);

        $subject->setCreatedBy(Argument::any())->shouldBeCalled();

        $this->setBlame($event);
    }

    function it_can_setTimestamp_on_the_event(GenericEvent $event, TimestampableInterface $subject)
    {
        $event->getSubject()->willReturn($subject);

        $subject->setCreatedAt(Argument::any())->shouldBeCalled();

        $this->setTimestamp($event);
    }
}
