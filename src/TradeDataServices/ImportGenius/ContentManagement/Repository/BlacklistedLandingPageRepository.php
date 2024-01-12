<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Repository;

use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;

interface BlacklistedLandingPageRepository
{
    public function store(LandingPage $landingPage);
}
