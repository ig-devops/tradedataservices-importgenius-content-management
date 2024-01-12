<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Handler;

use DateTimeImmutable;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Event;
use TradeDataServices\Common\Interfaces\EventDispatcher;
use TradeDataServices\Common\Interfaces\EventRecorder;
use TradeDataServices\Common\Interfaces\Handler;
use TradeDataServices\Common\Interfaces\IsEventDispatcherAware;
use TradeDataServices\Common\Interfaces\IsEventRecorderAware;
use TradeDataServices\ImportGenius\ContentManagement\Command\MarkLandingPageAsPrivate;
use TradeDataServices\ImportGenius\ContentManagement\Event\LandingPageWasMarkedAsPrivate;
use TradeDataServices\ImportGenius\ContentManagement\Exceptions\LandingPageIsNoLongerPublishedException;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PrivacyRequestRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PublishedLandingPageRepository;

class MarkLandingPageAsPrivateHandler implements
    Handler,
    IsEventDispatcherAware,
    IsEventRecorderAware
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
     * @var EventDispatcher[]
     */
    private $eventDispatchers = [];

    /**
     *
     * @var EventRecorder[]
     */
    private $eventRecorders = [];


    private function __construct(
        PublishedLandingPageRepository $publishedShipmentRepository,
        PrivacyRequestRepository $privacyRequestRepository
    ) {
    

        $this->publishedShipmentRepository = $publishedShipmentRepository;
        $this->privacyRequestRepository    = $privacyRequestRepository;
    }


    public static function create(
        PublishedLandingPageRepository $publishedShipmentRepository,
        PrivacyRequestRepository $privacyRequestRepository
    ) {
    

        $removeLandingPageHandler = new self(
            $publishedShipmentRepository,
            $privacyRequestRepository
        );

        return $removeLandingPageHandler;
    }


    /**
     * @todo Check published shipment repository if the landing page is existing
     *
     * @param MarkLandingPageAsPrivate $command
     */
    public function handle(MarkLandingPageAsPrivate $command)
    {
        $this->checkIfLandingPageIsStillPublished($command->landingPage());
        $this->performStorage($command->landingPage());
        $this->raiseEvents($command);
        $this->recordEvents();
    }


    private function checkIfLandingPageIsStillPublished(LandingPage $landingPage)
    {
        $id = $landingPage->id()->value();
        if ($this->publishedShipmentRepository->findById($id) instanceof LandingPage === false) {
            throw new LandingPageIsNoLongerPublishedException;
        }
        return $this;
    }


    private function performStorage(LandingPage $landingPage)
    {
        $this->privacyRequestRepository->store($landingPage);
        return $this;
    }


    private function raiseEvents($command)
    {
        $id        = Id::create(\uniqid());
        $occuredOn = new DateTimeImmutable;
        $this->raiseEvent(LandingPageWasMarkedAsPrivate::raise($id, $command, $occuredOn));
        return $this;
    }


    private function raiseEvent(Event $event)
    {
        if (count($this->eventDispatchers) > 0) {
            foreach ($this->eventDispatchers as $dispatcher) {
                $dispatcher->dispatch($event);
            }
        }
    }


    private function recordEvents()
    {

        if (count($this->eventDispatchers) > 0) {
            foreach ($this->eventDispatchers as $dispatcher) {
                $this->recordEvent($dispatcher);
            }
        }
    }


    private function recordEvent(EventDispatcher $dispatcher)
    {
        if (count($this->eventRecorders) > 0) {
            foreach ($this->eventRecorders as $recorder) {
                $recorder->storeDispatcherRecordedEvents($dispatcher);
            }
        }
    }


    /**
     *
     * @param EventDispatcher $eventDispatcher
     * @return int Number of registered Event Dispatchers
     */
    public function addEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $hash = \spl_object_hash($eventDispatcher);
        if (\array_key_exists($hash, $this->eventDispatchers) === false) {
            $this->eventDispatchers[$hash] = $eventDispatcher;
        }
        return count($this->eventDispatchers);
    }


    /**
     *
     * @param EventRecorder $eventRecorder
     * @return int Number of registered Event Recorders
     */
    public function addEventRecorder(EventRecorder $eventRecorder)
    {
        $hash = \spl_object_hash($eventRecorder);
        if (\array_key_exists($hash, $this->eventRecorders) === false) {
            $this->eventRecorders[$hash] = $eventRecorder;
        }
        return count($this->eventRecorders);
    }
}
