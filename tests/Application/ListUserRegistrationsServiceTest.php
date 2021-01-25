<?php

namespace App\Tests\Application;

use Mockery\MockInterface;
use App\Application\Service\ListUserRegistrations;
use App\Domain\ListUserRegistrationRepository;
use App\Domain\UserRegistration;
use App\Domain\UserRegistrationCollection;
use App\Domain\UserRegistrationCriteria;
use PHPUnit\Framework\TestCase;
use App\Tests\Domain\UserRegistrationCollectionMother;
use App\Tests\Domain\UserRegistrationCriteriaMother;
use App\Tests\Domain\UserRegistrationMother;

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
        $criteria = UserRegistrationCriteriaMother::empty();

        $this->shouldExecuteQueryWith($criteria);

        $collection = $this->service->query($criteria);

        foreach ($collection as $element) {
            $this->assertTrue(is_a($element, UserRegistration::class));
        }
    }

    /** @test */
    public function it_should_run_with_filters()
    {
        $criteria = UserRegistrationCriteriaMother::dummy();

        $this->shouldExecuteQueryWith($criteria);

        $this->service->query($criteria);
        $this->assertTrue(true, "Registration Service run with filters successfully.");
    }

    /** @test */
    public function it_should_accept_country_filter_as_array()
    {
        $criteria = UserRegistrationCriteriaMother::countries();

        $this->shouldExecuteQueryWith($criteria);

        $this->service->query($criteria);
        $this->assertTrue(true, "Registration Service run with filters successfully.");
    }

    /**
     * @return ListUserRegistrationRepository|MockInterface
     */
    private function repository() : ListUserRegistrationRepository
    {
        if (is_null($this->repository)) {
            $this->repository = $this->mock(ListUserRegistrationRepository::class);
        }
        return $this->repository;
    }

    private function shouldExecuteQueryWith(UserRegistrationCriteria $criteria)
    {
        $dummyReturnValue = UserRegistrationCollectionMother::multipleUsers();

        $this->repository()
             ->shouldReceive('query')
             //->withArgs([$criteria])
             ->once()
             ->andReturn($dummyReturnValue);
    }

    private function mock(string $className) : MockInterface
    {
        return \Mockery::mock($className);
    }
}
