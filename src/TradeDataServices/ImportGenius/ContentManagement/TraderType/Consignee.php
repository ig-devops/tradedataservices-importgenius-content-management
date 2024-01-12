<?php

namespace TradeDataServices\ImportGenius\ContentManagement\TraderType;

use TradeDataServices\Common\Abstracts\ValueObject;
use TradeDataServices\Common\Interfaces\ValueObject as ValueObjectInterface;

class Consignee extends ValueObject implements TraderType, ValueObjectInterface
{


    public function __construct()
    {
        $this->setValue("Consignee");
    }
}
