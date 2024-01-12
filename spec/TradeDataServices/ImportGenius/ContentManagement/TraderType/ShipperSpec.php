<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\TraderType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\Shipper;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class ShipperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Shipper::class);
        $this->shouldHaveType(TraderType::class);
    }

    function it_has_Name() {
        $this->value()->shouldReturn("Shipper");
    }
}
