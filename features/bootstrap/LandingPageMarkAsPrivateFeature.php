<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use TradeDataServices\Common\Classes\EventDispatcher;
use TradeDataServices\Common\Classes\EventRecorder;
use TradeDataServices\Common\Classes\FirstName;
use TradeDataServices\Common\Classes\FullName;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Classes\LastName;
use TradeDataServices\Common\Classes\PhpEventSerializer;
use TradeDataServices\Common\Classes\SerializedEvent;
use TradeDataServices\Common\Interfaces\Event;
use TradeDataServices\Common\Repository\EventRepository;
use TradeDataServices\ImportGenius\ContentManagement\Command\MarkLandingPageAsPrivate;
use TradeDataServices\ImportGenius\ContentManagement\Employee;
use TradeDataServices\ImportGenius\ContentManagement\Handler\MarkLandingPageAsPrivateHandler;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Page\UnitedStatesLandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Repository\BlacklistedLandingPageRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PrivacyRequestRepository;
use TradeDataServices\ImportGenius\ContentManagement\Repository\PublishedLandingPageRepository;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\Consignee;

/**
 * Defines application features from the specific context.
 */
class LandingPageMarkAsPrivateFeature implements Context
{

    /**
     *
     * @var Generator;
     */
    private $seeder;

    /**
     *
     * @var Employee
     */
    private $employee;

    /**
     *
     * @var LandingPage
     */
    private $landingPage;

    /**
     * @var PublishedLandingPageRepository
     */
    private $publishedLandingPageRepository;

    /**
     *
     * @var PrivacyRequestRepository
     */
    private $privacyRequestRepository;

    /**
     *
     * @var BlacklistedLandingPageRepository
     */
    private $blacklistedLandingPageRepository;

    /**
     *
     * @var EventRepository
     */
    private $eventRepository;


    public function __construct()
    {
        $this->publishedLandingPageRepository   = new InMemoryPublishedLandingPageRepository;
        $this->privacyRequestRepository         = new InMemoryPrivacyRequestRepository;
        $this->blacklistedLandingPageRepository = new InMemoryBlacklistedLandingPageRepository;
        $this->eventRepository                  = new InMemoryEventRepository;

        $this->seeder   = Factory::create();
        $id             = Id::create($this->seeder->randomDigit);
        $firstName      = FirstName::create($this->seeder->firstName);
        $lastName       = LastName::create($this->seeder->lastName);
        $fullName       = FullName::create($firstName, $lastName);
        $this->employee = Employee::create($id, $fullName);

        TestCase::assertInstanceOf(Employee::class, $this->employee);

    }


    /**
     * @Given I have a Landing Page.
     */
    public function iHaveALandingPage()
    {

        $id                = Id::create($this->seeder->randomDigit);
        $url               = implode('-', $this->seeder->words);
        $traderType        = new Consignee();
        $this->landingPage = UnitedStatesLandingPage::create($id, $traderType, $url);

        $this->publishedLandingPageRepository->store($this->landingPage);

        TestCase::assertInstanceOf(LandingPage::class, $this->landingPage);
        TestCase::assertInstanceOf(UnitedStatesLandingPage::class, $this->landingPage);

    }


    /**
     * @Given the Landing Page is in the list of Published Landing Pages.
     */
    public function theLandingPageIsInTheListOfPublishedLandingPages()
    {
        TestCase::assertNotFalse($this->publishedLandingPageRepository->findById($this->landingPage->id()->value()));

    }


    /**
     * @When I mark a Landing Page as Private.
     */
    public function iMarkALandingPageAsPrivate()
    {

        // Create Event Dispatcher
        $dispatcher = EventDispatcher::create();

        // Create Event Recorder
        $recorder = EventRecorder::create($this->eventRepository, new PhpEventSerializer());

        // Create Command
        $id      = Id::create($this->seeder->uuid);
        $command = MarkLandingPageAsPrivate::create($id, $this->employee, $this->landingPage);

        // Create Handler
        $handler = MarkLandingPageAsPrivateHandler::create(
                $this->publishedLandingPageRepository, $this->privacyRequestRepository
        );

        // Attach Event Dispatcher
        $handler->addEventDispatcher($dispatcher);

        // Attach Event Recorder
        $handler->addEventRecorder($recorder);

        // Handle the Command
        $handler->handle($command);

    }


    /**
     * @Then the Landing Page is Marked As Private.
     */
    public function theLandingPageIsMarkedAsPrivate()
    {
        TestCase::assertNotFalse($this->privacyRequestRepository->findById($this->landingPage->id()->value()));

    }


    /**
     * @Then the Landing Page is Permanently Black Listed.
     */
    public function theLandingPageIsPermanentlyBlackListed()
    {
        TestCase::assertNotFalse($this->blacklistedLandingPageRepository->findById($this->landingPage->id()->value()));

    }


    /**
     * @Then the Landing Page should be removed from the list of Published Landing Pages.
     */
    public function theLandingPageShouldBeRemovedFromTheListOfPublishedLandingPages()
    {
        TestCase::assertFalse($this->publishedLandingPageRepository->findById($this->landingPage->id()->value()));

    }


    /**
     * @Then all the Events are recorded in the Audit Trail.
     */
    public function allTheEventsAreRecordedInTheAuditTrail()
    {
        TestCase::assertGreaterThan(0, $this->eventRepository->count());

    }
}