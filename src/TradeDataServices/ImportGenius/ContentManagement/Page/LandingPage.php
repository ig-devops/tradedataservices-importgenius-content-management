<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Page;

use TradeDataServices\Common\Classes\Id;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

abstract class LandingPage
{

    const IMPORT_DATA_IMPORTER  = 2;
    const IMPORT_DATA_SUPPLIER  = 0;
    const EXPORT_DATA_CONSIGNEE = 1;
    const EXPORT_DATA_EXPORTER  = 3;
    const EXPORT_DATA_BUYER     = 1;

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
     * @var int
     */
    private $traderType;

    /**
     *
     * @var string
     */
    private $country;

    /**
     *
     * @var string
     */
    private $countryAbbreviation;


    /**
     *
     * @param Id $id
     * @param TraderType $traderType
     * @param type $url
     */
    protected function __construct(Id $id, TraderType $traderType, $url)
    {
        $this->id         = $id;
        $this->url        = $url;
        $this->traderType = $traderType;
    }


    public function id()
    {
        return $this->id;
    }


    public function url()
    {
        return $this->url;
    }


    public function traderType()
    {
        return $this->traderType;
    }


    public function countryAbbreviation()
    {
        return $this->countryAbbreviation;
    }


    public function country()
    {
        return $this->country;
    }


    protected function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }


    protected function setCountryAbbreviation($countryAbbreviation)
    {
        $this->countryAbbreviation = $countryAbbreviation;
        return $this;
    }
}
