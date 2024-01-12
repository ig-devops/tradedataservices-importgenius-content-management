<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RuntimeException;
use Exception;
use TradeDataServices\ImportGenius\ContentManagement\Exceptions\LandingPageClassDoesNotExistException;

class LandingPageClassDoesNotExistExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LandingPageClassDoesNotExistException::class);
        $this->shouldHaveType(Exception::class);
        $this->shouldHaveType(RuntimeException::class);
    }
}
