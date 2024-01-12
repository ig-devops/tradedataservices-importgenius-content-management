<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Page;

use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Entity;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class VietnamLandingPage extends LandingPage implements Entity
{
    public static function create(ID $id, TraderType $traderType, $url)
    {
        $landingPage = new VietnamLandingPage($id, $traderType, $url);
        $landingPage->setCountryAbbreviation('VN');
        $landingPage->setCountry('Vietnam');

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
