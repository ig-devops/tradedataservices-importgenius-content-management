<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Repository;

use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;

interface PrivacyRequestRepository
{

    public function store(LandingPage $landingPage);
}
