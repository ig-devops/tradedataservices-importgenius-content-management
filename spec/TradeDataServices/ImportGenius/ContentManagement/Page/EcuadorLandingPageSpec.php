<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Page;

use Faker\Factory;
use Faker\Generator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Entity;
use TradeDataServices\ImportGenius\ContentManagement\Page\EcuadorLandingPage;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class EcuadorLandingPageSpec extends ObjectBehavior
{

    /**
     *
     * @var Generator
     */
    private $seeder;

    /**
     *
     * @var Id
     */
    private $id;

    /**
     *
     * @var string
     */
    private $url;

    /**
     *
     * @var integer
     */
    private $traderType;


    function let(TraderType $traderType)
    {
        $this->seeder     = Factory::create();
        $this->id         = Id::create($this->seeder->randomDigit);
        $this->url        = implode('-', $this->seeder->words);
        $this->traderType = $traderType;
        $this->beConstructedThrough('create', [$this->id, $this->traderType, $this->url]);

    }


    function it_is_initializable()
    {
        $this->shouldHaveType(EcuadorLandingPage::class);
        $this->shouldHaveType(LandingPage::class);
        $this->shouldHaveType(Entity::class);

    }


    function it_has_Id()
    {
        $this->id()->shouldReturn($this->id);

    }


    function it_has_Url()
    {
        $this->url()->shouldReturn($this->url);

    }


    function it_has_Trader_Type()
    {
        $this->traderType()->shouldReturn($this->traderType);

    }


    function it_has_Country_Abbreviation()
    {
        $this->countryAbbreviation()->shouldReturn("EC");

    }


    function it_has_Country()
    {
        $this->country()->shouldReturn("Ecuador");

    }
}
