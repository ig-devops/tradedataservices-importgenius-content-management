<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use TradeDataServices\Common\Classes\SerializedEvent;
use TradeDataServices\Common\Interfaces\Event;
use TradeDataServices\Common\Repository\EventRepository;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Repository\BlacklistedLandingPageRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PrivacyRequestRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PublishedLandingPageRepository;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }
}

class InMemoryPublishedLandingPageRepository implements PublishedLandingPageRepository
{

    /**
     *
     * @var LandingPage[]
     */
    private $landingPages = [];


    public function store(LandingPage $landingPage)
    {
        $this->landingPages[$landingPage->id()->value()] = $landingPage;

    }


    public function findById($id)
    {
        return isset($this->landingPages[$id]) ? $this->landingPages[$id] : false;

    }


    public function remove(LandingPage $landingPage)
    {
        if (isset($this->landingPages[$landingPage->id()->value()])) {
            unset($this->landingPages[$landingPage->id()->value()]);
        }
        return false;

    }
}

class InMemoryPrivacyRequestRepository implements PrivacyRequestRepository
{

    /**
     *
     * @var LandingPage[]
     */
    private $landingPages = [];


    public function store(LandingPage $landingPage)
    {
        $this->landingPages[$landingPage->id()->value()] = $landingPage;

    }


    public function findById($id)
    {
        return isset($this->landingPages[$id]) ? $this->landingPages[$id] : false;

    }
}

class InMemoryBlacklistedLandingPageRepository implements BlacklistedLandingPageRepository
{

    /**
     *
     * @var LandingPage[]
     */
    private $landingPages = [];


    public function store(LandingPage $landingPage)
    {
        $this->landingPages[$landingPage->id()->value()] = $landingPage;

    }


    public function findById($id)
    {
        return isset($this->landingPages[$id]) ? $this->landingPages[$id] : false;

    }
}

class InMemoryEventRepository implements EventRepository
{

    /**
     *
     * @var Event[]
     */
    private $serializedEvents = [];


    public function store(SerializedEvent $serializedEvent)
    {
        $this->serializedEvents[] = $serializedEvent;

    }


    public function count()
    {
        return count($this->serializedEvents);

    }
}
