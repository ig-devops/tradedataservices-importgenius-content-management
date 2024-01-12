<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Handler;

use Faker\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\Common\Classes\EventRecorder;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\EventDispatcher;
use TradeDataServices\Common\Interfaces\Handler;
use TradeDataServices\Common\Interfaces\IsEventDispatcherAware;
use TradeDataServices\Common\Interfaces\IsEventRecorderAware;
use TradeDataServices\ImportGenius\ContentManagement\Command\RemoveLandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Event\LandingPageWasBlackListed;
use TradeDataServices\ImportGenius\ContentManagement\Event\LandingPageWasMarkedAsPrivate;
use TradeDataServices\ImportGenius\ContentManagement\Event\LandingPageWasUnpublished;
use TradeDataServices\ImportGenius\ContentManagement\Exceptions\LandingPageIsNoLongerPublishedException;
use TradeDataServices\ImportGenius\ContentManagement\Handler\RemoveLandingPageHandler;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Repository\BlacklistedLandingPageRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PrivacyRequestRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PublishedLandingPageRepository;

class RemoveLandingPageHandlerSpec extends ObjectBehavior
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
     * @var BlacklistedLandingPageRepository
     */
    private $blackListedLandingPageRepository;

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


    function let(PublishedLandingPageRepository $publishedShipmentRepository, PrivacyRequestRepository $privacyRequestRepository, BlacklistedLandingPageRepository $blackListedLandingPageRepository, EventDispatcher $eventDispatcher, EventRecorder $eventRecorder)
    {
        $this->publishedShipmentRepository      = $publishedShipmentRepository;
        $this->privacyRequestRepository         = $privacyRequestRepository;
        $this->blackListedLandingPageRepository = $blackListedLandingPageRepository;
        $this->eventDispatcher                  = $eventDispatcher;
        $this->eventRecorder                    = $eventRecorder;
        $this->beConstructedThrough('create', [$publishedShipmentRepository, $privacyRequestRepository,
            $blackListedLandingPageRepository]);

    }


    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveLandingPageHandler::class);
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


    function it_throws_LandingPageIsNoLongerPublishedException(RemoveLandingPage $command, LandingPage $landingPage, Id $id)
    {
        $fakeId = Factory::create()->uuid;
        $id->value()->shouldBeCalled()->willReturn($fakeId);
        $landingPage->id()->shouldBeCalled()->willReturn($id);

        $command->landingPage()->shouldBeCalled()->willReturn($landingPage);
        $this->publishedShipmentRepository->findById($fakeId)->shouldBeCalled()->willReturn(false);
        $this->shouldThrow(LandingPageIsNoLongerPublishedException::class)->duringHandle($command);

    }


    function it_handles_the_Command(RemoveLandingPage $command, LandingPage $landingPage, Id $id)
    {
        $this->addEventDispatcher($this->eventDispatcher);
        $this->addEventRecorder($this->eventRecorder);
        $fakeId = Factory::create()->uuid;
        $id->value()->shouldBeCalled()->willReturn($fakeId);
        $landingPage->id()->shouldBeCalled()->willReturn($id);

        $command->landingPage()->shouldBeCalled()->willReturn($landingPage);
        $this->publishedShipmentRepository->findById($fakeId)->shouldBeCalled()->willReturn($landingPage);
        $this->publishedShipmentRepository->remove($landingPage)->shouldBeCalled();
        $this->privacyRequestRepository->store($landingPage)->shouldBeCalled();
        $this->blackListedLandingPageRepository->store($landingPage)->shouldBeCalled();

        $this->eventDispatcher->dispatch(Argument::type(LandingPageWasMarkedAsPrivate::class))
            ->shouldBeCalled();
        $this->eventDispatcher->dispatch(Argument::type(LandingPageWasBlackListed::class))
            ->shouldBeCalled();
        $this->eventDispatcher->dispatch(Argument::type(LandingPageWasUnpublished::class))
            ->shouldBeCalled();

        $this->eventRecorder->storeDispatcherRecordedEvents($this->eventDispatcher)->shouldBeCalled();

        $this->handle($command);

    }
}
