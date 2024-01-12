<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Event;

use DateTimeImmutable;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Event;
use TradeDataServices\ImportGenius\ContentManagement\Command\LandingPageCommand;
use TradeDataServices\ImportGenius\ContentManagement\Command\RemoveLandingPage;

class LandingPageWasUnpublished implements Event
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


    private function __construct(Id $id, LandingPageCommand $command, DateTimeImmutable $occuredOn)
    {
        $this->command   = $command;
        $this->id        = $id;
        $this->occuredOn = $occuredOn;
    }


    public static function raise(Id $id, LandingPageCommand $command, DateTimeImmutable $occuredOn)
    {
        return new LandingPageWasUnpublished($id, $command, $occuredOn);
    }


    public function getCommand()
    {
        return $this->command;
    }


    public function id()
    {
        return $this->id;
    }


    public function name()
    {
        return \get_class($this);
    }


    public function occuredOn()
    {
        return $this->occuredOn;
    }
}
