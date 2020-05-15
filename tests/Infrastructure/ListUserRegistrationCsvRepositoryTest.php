<?php


namespace TestOrg\Infrastructure;

use PHPUnit\Framework\TestCase;
use TestOrg\Domain\UserRegistrationCriteria;

class ListUserRegistrationCsvRepositoryTest extends TestCase
{
    // private $service;
    private $repository;

    // Sample data
    const USER_LIST_FILE=__DIR__."/../Data/test.csv";

    // Compiled expected results (ordered list of element ids, reordered incrementally to validate filters)
    const EXPECTED_ORDER=[7,11,2,12,1,8,13,9,5,10,6,3,4]; // compiled manually ndlr
    const EXPECTED_FILTERED_COUNTRIES_CN_JP=[5,7,9]; // incremental ids
    const EXPECTED_FILTERED_ACTIVATION_LENGTH_0=[1,2,3,4,5,6,7,8,9,10,11,12,13];
    const EXPECTED_FILTERED_ACTIVATION_LENGTH_19=[1,7,13];
    const EXPECTED_FILTERED_ACTIVATION_LENGTH_100=[];
    const EXPECTED_FILTERED_BOTH_CN_JP_5=[];
    const EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19=[7];

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ListUserRegistrationCsvRepository(self::USER_LIST_FILE);
    }

    private function executeQueryWithParameters($parameters=[])
    {
        $criteria = new UserRegistrationCriteria($parameters);
        return $this->repository->query($criteria);
    }

    /* @test */
    public function it_should_return_the_full_list_if_no_filter_is_specified()
    {
        $collection = $this->executeQueryWithParameters();

        $this->assertCount(13, $collection->asArray(), "Parsed list has 13 elements");
    }

    /* @test */
    public function it_should_order_list_elements_by_name_and_surname()
    {
        $collection = $this->executeQueryWithParameters();

        $orderedIds = array_column($collection->asArray(), 'id');
        $this->assertTrue($orderedIds == self::EXPECTED_ORDER, "List is ordered by name and surname");
    }

    /* @test */
    public function it_should_filter_countries_specified_in_coutries_filter()
    {
        $collection = $this->executeQueryWithParameters(["countries"=>"JP,CN"]);

        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_COUNTRIES_CN_JP, "JP and CN countries are filtered correctly.");
    }

    /**
    /* @test
     * Edge case - country filter is empty
     */
    public function it_should_return_empty_list_when_country_filter_is_set_to_empty_list()
    {
        $collection = $this->executeQueryWithParameters(["countries"=>""]);

        $this->assertEmpty($collection->asArray(), "Empty list of countries leads to empty list of users.");
    }

    /**
    /* @test
     * Edge case - country filter contains all countries
     */
    public function it_should_return_all_registrations_when_country_filter_contains_all_countries()
    {
        $collection = $this->executeQueryWithParameters(["countries"=>"JO,VN,RS,GR,CN,PH,MA,JP,SE,PL,US,AZ"]);

        $this->assertCount(13, $collection->asArray(), "Parsed list has 13 elements after filtering all existing countries");
    }

    /**
    /* @test
     * Edge case - activation length 0 day
     */
    public function it_should_return_all_registrations_when_activation_length_filter_is_0()
    {
        $collection = $this->executeQueryWithParameters(["activation_length"=>0]);

        $this->assertCount(13, $collection->asArray(), "Parsed list has 13 elements after filtering activation length 0");
    }

    /**
     * @test
     * Filter activation length 19 days
     */
    public function it_should_apply_filter_correctly_when_activation_length_is_19_days()
    {
        $collection = $this->executeQueryWithParameters(["activation_length"=>19]);

        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_ACTIVATION_LENGTH_19, "Activation length of 19 days is filtered out correctly.");
    }

    /**
     * @test
     * Edge case - activation length 100 days
     */
    public function it_should_show_all_registrations_when_activation_lenght_filter_is_100()
    {
        $collection = $this->executeQueryWithParameters(["activation_length"=>100]);

        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_ACTIVATION_LENGTH_100, "Activation length of 100 days is filtered out correctly.");
    }

    /**
     * @test
     * Filter activation length 10 days and countries
     */
    public function it_should_combine_filters_correctly()
    {
        $collection = $this->executeQueryWithParameters(["activation_length"=>19, "countries"=>"JP,CN"]);
        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19, "Activation length of 19 days is filtered out correctly.");
    }

    /**
     * @test
     * Check that result does not change when previous queries have been run.
     */
    public function it_should_execute_consecutive_queries_independently()
    {
        $this->executeQueryWithParameters([ "countries"=>"US"]);
        $collection = $this->executeQueryWithParameters(["activation_length"=>19, "countries"=>"JP,CN"]);
        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19, "Activation length of 19 days is filtered out correctly.");
    }
}
