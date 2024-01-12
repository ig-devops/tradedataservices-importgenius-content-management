<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\ImportGenius\ContentManagement\Exceptions\LandingPageIsNoLongerPublishedException;

class LandingPageIsNoLongerPublishedExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LandingPageIsNoLongerPublishedException::class);
        $this->shouldHaveType(\Exception::class);
    }
}
