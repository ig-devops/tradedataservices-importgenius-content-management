<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Handler;

error_reporting(E_ALL);

use Faker\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\Common\Classes\EventRecorder;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\EventDispatcher;
use TradeDataServices\Common\Interfaces\Handler;
use TradeDataServices\Common\Interfaces\IsEventDispatcherAware;
use TradeDataServices\Common\Interfaces\IsEventRecorderAware;
use TradeDataServices\ImportGenius\ContentManagement\Command\MarkLandingPageAsPrivate;
use TradeDataServices\ImportGenius\ContentManagement\Event\LandingPageWasMarkedAsPrivate;
use TradeDataServices\ImportGenius\ContentManagement\Exceptions\LandingPageIsNoLongerPublishedException;
use TradeDataServices\ImportGenius\ContentManagement\Handler\MarkLandingPageAsPrivateHandler;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PrivacyRequestRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PublishedLandingPageRepository;

class MarkLandingPageAsPrivateHandlerSpec extends ObjectBehavior
{

    /**
     *
     * @var PublishedLandingPageRepository
     */
    private $publishedShipmentRepository;

    /**
     *
     * @var PrivacyRequestRepository
     */
    private $privacyRequestRepository;

    /**
     *
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     *
     * @var EventRecorder
     */
    private $eventRecorder;


    function let(PublishedLandingPageRepository $publishedShipmentRepository, PrivacyRequestRepository $privacyRequestRepository, EventDispatcher $eventDispatcher, EventRecorder $eventRecorder)
    {
        $this->publishedShipmentRepository = $publishedShipmentRepository;
        $this->privacyRequestRepository    = $privacyRequestRepository;
        $this->eventDispatcher             = $eventDispatcher;
        $this->eventRecorder               = $eventRecorder;
        $this->beConstructedThrough('create', [$publishedShipmentRepository, $privacyRequestRepository]);

    }


    function it_is_initializable()
    {
        $this->shouldHaveType(MarkLandingPageAsPrivateHandler::class);
        $this->shouldHaveType(Handler::class);
        $this->shouldHaveType(IsEventDispatcherAware::class);
        $this->shouldHaveType(IsEventRecorderAware::class);

    }


    function it_accepts_Event_Dispatcher()
    {
        $this->addEventDispatcher($this->eventDispatcher)->shouldReturn(1);

    }


    function it_ignores_Existing_Event_Dispatcher()
    {
        $this->addEventDispatcher($this->eventDispatcher)->shouldReturn(1);
        $this->addEventDispatcher($this->eventDispatcher)->shouldReturn(1);
        $this->addEventDispatcher($this->eventDispatcher)->shouldReturn(1);

    }


    function it_accepts_Event_Recorder()
    {
        $this->addEventRecorder($this->eventRecorder)->shouldReturn(1);

    }


    function it_ignores_Existing_Event_Recorder()
    {
        $this->addEventRecorder($this->eventRecorder)->shouldReturn(1);
        $this->addEventRecorder($this->eventRecorder)->shouldReturn(1);
        $this->addEventRecorder($this->eventRecorder)->shouldReturn(1);

    }


    function it_throws_LandingPageIsNoLongerPublishedException(MarkLandingPageAsPrivate $command, LandingPage $landingPage, Id $id)
    {
        $fakeId = Factory::create()->uuid;
        $id->value()->shouldBeCalled()->willReturn($fakeId);
        $landingPage->id()->shouldBeCalled()->willReturn($id);

        $command->landingPage()->shouldBeCalled()->willReturn($landingPage);
        $this->publishedShipmentRepository->findById($fakeId)->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(LandingPageIsNoLongerPublishedException::class)->duringHandle($command);

    }


    function it_handles_the_Command(MarkLandingPageAsPrivate $command, LandingPage $landingPage, Id $id)
    {
        $this->addEventDispatcher($this->eventDispatcher);
        $this->addEventRecorder($this->eventRecorder);

        $fakeId = Factory::create()->uuid;
        $id->value()->shouldBeCalled()->willReturn($fakeId);
        $landingPage->id()->shouldBeCalled()->willReturn($id);

        $command->landingPage()->shouldBeCalled()->willReturn($landingPage);
        $this->publishedShipmentRepository->findById($fakeId)->shouldBeCalled()->willReturn($landingPage);
        $this->privacyRequestRepository->store($landingPage)->shouldBeCalled();

        $this->eventDispatcher->dispatch(Argument::type(LandingPageWasMarkedAsPrivate::class))
            ->shouldBeCalled();

        $this->eventRecorder->storeDispatcherRecordedEvents($this->eventDispatcher)->shouldBeCalled();

        $this->handle($command);

    }
}
