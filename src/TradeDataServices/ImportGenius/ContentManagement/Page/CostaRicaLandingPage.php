<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Page;

use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Interfaces\Entity;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class CostaRicaLandingPage extends LandingPage implements Entity
{


    public static function create(Id $id, TraderType $traderType, $url)
    {
        $costaRicaLandingPage = new CostaRicaLandingPage($id, $traderType, $url);
        $costaRicaLandingPage->setCountryAbbreviation('CR');
        $costaRicaLandingPage->setCountry('Costa Rica');

        return $costaRicaLandingPage;
    }


    public function id()
    {
        return parent::id();
    }


    public function url()
    {
        return parent::url();
    }


    public function traderType()
    {
        return parent::traderType();
    }


    public function countryAbbreviation()
    {
        return parent::countryAbbreviation();
    }


    public function country()
    {
        return parent::country();
    }


    protected function setCountry($country)
    {
        return parent::setCountry($country);
    }


    protected function setCountryAbbreviation($countryAbbreviation)
    {
        return parent::setCountryAbbreviation($countryAbbreviation);
    }
}
