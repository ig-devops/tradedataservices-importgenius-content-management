<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Factory;

use TradeDataServices\Common\Classes\Id;
use TradeDataServices\ImportGenius\ContentManagement\Exceptions\LandingPageClassDoesNotExistException;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class LandingPageFactory
{


    public static function create($countryName, Id $id, TraderType $traderType, $url)
    {
        $lowerCasedCountry = \strtolower($countryName);
        $ucFirstCountry    = \ucwords($lowerCasedCountry);
        $trimmedCountry    = \str_replace(' ', '', $ucFirstCountry);
        $class             = "TradeDataServices\\ImportGenius\\"
            . "ContentManagement\\Page\\" . $trimmedCountry . "LandingPage";

        if (\class_exists($class) === false) {
            throw new LandingPageClassDoesNotExistException;
        }
        return $class::create($id, $traderType, $url);
    }
}
