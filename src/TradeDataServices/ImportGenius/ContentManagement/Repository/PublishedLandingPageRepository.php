<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Repository;

use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;

interface PublishedLandingPageRepository
{
    public function store(LandingPage $landingPage);

    public function findById($id);

    public function remove(LandingPage $landingPage);
}
