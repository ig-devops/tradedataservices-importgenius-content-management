<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Factory;

use Faker\Factory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\ImportGenius\ContentManagement\Factory\LandingPageFactory;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class LandingPageFactorySpec extends ObjectBehavior
{


    function it_is_initializable()
    {
        $this->shouldHaveType(LandingPageFactory::class);

    }


    function it_creates_Landing_Pages(TraderType $traderType)
    {
        $countries = [
            'Argentina', 'Chile', 'Colombia', 'Costa Rica', 'ECUADOR', 'india',
            'PaNaMa', 'Paraguay', 'Peru', 'Russia', 'uKrAiNe', 'UNITED states',
            'Uruguay', 'VenezueLA'
        ];

        foreach ($countries as $countryName) {
            $lowerCasedCountry = \strtolower($countryName);
            $ucFirstCountry    = \ucwords($lowerCasedCountry);
            $trimmedCountry    = \str_replace(' ', '', $ucFirstCountry);
            $class             = "TradeDataServices\\ImportGenius\\ContentManagement\\Page\\" . $trimmedCountry . "LandingPage";

            $id  = Id::create(Factory::create()->uuid);
            $url = \str_replace(' ', '', \strtolower(Factory::create()->name));
            $this->create($countryName, $id, $traderType, $url)->shouldHaveType(LandingPage::class);
            $this->create($countryName, $id, $traderType, $url)->shouldHaveType($class);
        }

    }


    function it_throws_LandingPageClassDoesNotExistException(TraderType $traderType)
    {

        $countries = [
            'Antartica', 'ARCTIC', 'PaCiFiC'
        ];

        foreach ($countries as $countryName) {
            $lowerCasedCountry = \strtolower($countryName);
            $ucFirstCountry    = \ucfirst($lowerCasedCountry);
            $trimmedCountry    = \str_replace(' ', '', $ucFirstCountry);

            $id  = Id::create(Factory::create()->uuid);
            $url = \str_replace(' ', '', \strtolower(Factory::create()->name));
            $this->shouldThrow(\TradeDataServices\ImportGenius\ContentManagement\Exceptions\LandingPageClassDoesNotExistException::class)
                ->duringCreate($trimmedCountry, $id, $traderType, $url);
        }

    }
}
