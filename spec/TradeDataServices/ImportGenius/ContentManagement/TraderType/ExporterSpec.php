<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\TraderType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\Exporter;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class ExporterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Exporter::class);
        $this->shouldHaveType(TraderType::class);
    }

    function it_has_Name() {
        $this->value()->shouldReturn("Exporter");
    }
}
