<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Command;

use Faker\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Command;
use TradeDataServices\ImportGenius\ContentManagement\Employee;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Command\RemoveLandingPage;

class RemoveLandingPageSpec extends ObjectBehavior
{

    /**
     *
     * @var string
     */
    private $id;

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


    function let(Employee $employee, LandingPage $landingPage)
    {
        $this->id          = Id::create(Factory::create()->uuid);
        $this->employee    = $employee;
        $this->landingPage = $landingPage;

        $this->beConstructedThrough('create', [$this->id, $this->employee, $this->landingPage]);

    }


    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveLandingPage::class);
        $this->shouldHaveType(Command::class);

    }


    function it_has_Id()
    {
        $this->id()->shouldReturn($this->id);

    }


    function it_has_Employee()
    {
        $this->employee()->shouldReturn($this->employee);

    }


    function it_has_Landing_Page()
    {
        $this->landingPage()->shouldReturn($this->landingPage);

    }
}
