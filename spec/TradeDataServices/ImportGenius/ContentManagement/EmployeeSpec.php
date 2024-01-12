<?php

namespace spec\TradeDataServices\ImportGenius\ContentManagement;

use Faker\Factory;
use Faker\Generator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TradeDataServices\Common\Classes\FirstName;
use TradeDataServices\Common\Classes\FullName;
use TradeDataServices\Common\Classes\Id;
use TradeDataServices\Common\Classes\LastName;
use TradeDataServices\ImportGenius\ContentManagement\Employee;

class EmployeeSpec extends ObjectBehavior
{

    /**
     *
     * @var Generator
     */
    private $seeder;
    private $firstName;
    private $lastName;
    private $fullName;
    private $id;


    function it_is_initializable()
    {
        $this->seeder    = Factory::create();
        $this->id        = Id::create($this->seeder->uuid);
        $this->firstName = FirstName::create($this->seeder->firstName);
        $this->lastName  = LastName::create($this->seeder->lastName);
        $this->fullName  = FullName::create($this->firstName, $this->lastName);

        $this->beConstructedThrough('create', [$this->id, $this->fullName]);
        $this->shouldHaveType(Employee::class);

    }
}
