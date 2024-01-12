<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\TraderType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\Consignee;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class ConsigneeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Consignee::class);
        $this->shouldHaveType(TraderType::class);
    }

    function it_has_Name() {
        $this->value()->shouldReturn("Consignee");
    }
}
