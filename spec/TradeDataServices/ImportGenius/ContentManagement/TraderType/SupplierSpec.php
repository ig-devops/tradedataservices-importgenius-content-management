<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\TraderType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\Supplier;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class SupplierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Supplier::class);
        $this->shouldHaveType(TraderType::class);
    }

    function it_has_Name() {
        $this->value()->shouldReturn("Supplier");
    }
}
