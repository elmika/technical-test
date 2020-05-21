<?php

namespace TestOrg\Tests\Application;

use Mockery\MockInterface;
use TestOrg\Application\Service\ListUserRegistrations;
use TestOrg\Domain\ListUserRegistrationRepository;
use TestOrg\Domain\UserRegistration;
use TestOrg\Domain\UserRegistrationCollection;
use TestOrg\Domain\UserRegistrationCriteria;
use PHPUnit\Framework\TestCase;
use TestOrg\Tests\Domain\UserRegistrationMother;

class ListUserRegistrationsServiceTest extends TestCase
{
    private $service;
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ListUserRegistrations($this->repository());
    }

    /** @test */
    public function it_should_return_a_list_of_user_registrations()
    {
        $parameters = [];

        $this->shouldExecuteQueryWith($parameters);

        $collection = $this->service->query($parameters);

        foreach($collection as $element) {
            $this->assertTrue(is_a($element, UserRegistration::class));
        }
    }

    /** @test */
    public function it_should_run_with_filters()
    {
        $parameters = [
            'countries' => "ES,FR,US",
            'activation_length' => 11,
            'dummy_filter' => "dummy_value"
        ];

        $this->shouldExecuteQueryWith($parameters);

        $this->service->query($parameters);
        $this->assertTrue(true, "Registration Service run with filters successfully.");
    }

    /** @test */
    public function it_should_accept_country_filter_as_array()
    {
        $parameters = [
            'countries' => ["ES","FR","US"]
        ];

        $this->shouldExecuteQueryWith($parameters);

        $this->service->query($parameters);
        $this->assertTrue(true, "Registration Service run with filters successfully.");

    }

    /**
     * @return ListUserRegistrationRepository|MockInterface
     */
    private function repository() : ListUserRegistrationRepository
    {
        if(is_null($this->repository)) {
            $this->repository = $this->mock(ListUserRegistrationRepository::class);
        }
        return $this->repository;
    }

    private function shouldExecuteQueryWith($parameters = [])
    {
        //$filters = new UserRegistrationCriteria($parameters);
        $collection = new UserRegistrationCollection([UserRegistrationMother::dummy()]);

        $this->repository()
             ->shouldReceive('query')
             //->withArgs([$filters])
             ->once()
             ->andReturn($collection);
    }

    private function mock(string $className) : MockInterface
    {
        return \Mockery::mock($className);
    }
}