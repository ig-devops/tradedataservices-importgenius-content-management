<?php

namespace TradeDataServices\ImportGenius\ContentManagement;

use TradeDataServices\Common\Classes\FullName;
use TradeDataServices\Common\Classes\Id;

class Employee
{

    /**
     *
     * @var Id
     */
    private $id;

    /**
     *
     * @var FullName
     */
    private $fullName;


    private function __construct(Id $id, FullName $fullName)
    {
        $this->id       = $id;
        $this->fullName = $fullName;
    }


    public static function create(Id $id, FullName $fullName)
    {
        return new Employee($id, $fullName);
    }
}
