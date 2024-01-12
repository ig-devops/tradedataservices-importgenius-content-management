<?php

namespace TradeDataServices\ImportGenius\ContentManagement\Command;

use TradeDataServices\Common\Classes\Id;
use TradeDataServices\ImportGenius\ContentManagement\Command\LandingPageCommand;
use TradeDataServices\ImportGenius\ContentManagement\Employee;
use TradeDataServices\ImportGenius\ContentManagement\Page\LandingPage;

class RemoveLandingPage implements LandingPageCommand
{

    /**
     *
     * @var Id
     */
    private $id;

    /**
     *
     * @var Employee
     */
    private $employee;

    /**
     *
     * @var LandingPage
     */
    private $landingPage;


    private function __construct(Id $id, Employee $employee, LandingPage $landingPage)
    {
        $this->id          = $id;
        $this->employee    = $employee;
        $this->landingPage = $landingPage;
    }


    /**
     *
     * @param Id $id
     * @param Employee $employee
     * @param LandingPage $landingPage
     * @return RemoveLandingPage
     */
    public static function create(Id $id, Employee $employee, LandingPage $landingPage)
    {
        return new self($id, $employee, $landingPage);
    }


    /**
     *
     * @return Id
     */
    public function id()
    {
        return $this->id;
    }


    /**
     *
     * @return Employee
     */
    public function employee()
    {
        return $this->employee;
    }


    /**
     *
     * @return LandingPage
     */
    public function landingPage()
    {
        return $this->landingPage;
    }
}
