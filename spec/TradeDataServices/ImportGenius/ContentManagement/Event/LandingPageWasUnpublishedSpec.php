<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Event;

use DateTime;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Command;
use TradeDataServices\Common\Interfaces\Event;
use TradeDataServices\ImportGenius\ContentManagement\Event\LandingPageWasUnpublished;
use TradeDataServices\ImportGenius\ContentManagement\Command\RemoveLandingPage;

class LandingPageWasUnpublishedSpec extends ObjectBehavior
{

    /**
     *
     * @var RemoveLandingPage
     */
    private $command;

    /**
     *
     * @var Id
     */
    private $id;

    /**
     *
     * @var DateTimeImmutable
     */
    private $occuredOn;


    function let(Id $id, RemoveLandingPage $command)
    {
        $this->id        = $id;
        $this->command   = $command;
        $this->occuredOn = new \DateTimeImmutable;
        $this->beConstructedThrough('raise', [$this->id, $this->command, $this->occuredOn]);

    }


    function it_is_initializable()
    {
        $this->shouldHaveType(LandingPageWasUnpublished::class);
        $this->shouldHaveType(Event::class);

    }


    function it_has_Command()
    {
        $this->getCommand()->shouldReturn($this->command);

    }


    function it_has_Id()
    {
        $this->id()->shouldReturn($this->id);

    }


    function it_has_Name()
    {
        $this->name()->shouldReturn(\get_class($this->getWrappedObject()));

    }


    function it_has_Date_Occured()
    {
        $this->occuredOn()->shouldReturn($this->occuredOn);

    }
}
