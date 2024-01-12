<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Page;

use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Entity;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class PanamaLandingPage extends LandingPage implements Entity
{


    public static function create(Id $id, TraderType $traderType, $url)
    {
        $landingPage = new PanamaLandingPage($id, $traderType, $url);
        $landingPage->setCountryAbbreviation('PA');
        $landingPage->setCountry('Panama');

        return $landingPage;
    }


    public function country()
    {
        return parent::country();
    }


    public function countryAbbreviation()
    {
        return parent::countryAbbreviation();
    }


    public function id()
    {
        return parent::id();
    }


    protected function setCountry($country)
    {
        return parent::setCountry($country);
    }


    protected function setCountryAbbreviation($countryAbbreviation)
    {
        return parent::setCountryAbbreviation($countryAbbreviation);
    }


    public function traderType()
    {
        return parent::traderType();
    }


    public function url()
    {
        return parent::url();
    }
}
