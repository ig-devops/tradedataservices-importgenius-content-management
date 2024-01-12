<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\TraderType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\Buyer;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class BuyerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Buyer::class);
        $this->shouldHaveType(TraderType::class);
    }

    function it_has_Name() {
        $this->value()->shouldReturn("Buyer");
    }
}
