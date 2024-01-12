<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\TraderType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\Importer;
use TradeDataServices\ImportGenius\ContentManagement\TraderType\TraderType;

class ImporterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Importer::class);
        $this->shouldHaveType(TraderType::class);
    }

    function it_has_Name() {
        $this->value()->shouldReturn("Importer");
    }
}
