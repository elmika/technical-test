<?php


namespace App\Tests\Application;


use App\Application\ListUserRegistrationsService;
use App\Infrastructure\ListUserRegistrationCsvRepository;
use PHPUnit\Framework\TestCase;

class ListUserRegistrationsServiceTest extends TestCase
{
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

    private function buildSampleService()
    {
        $repository = new ListUserRegistrationCsvRepository(self::USER_LIST_FILE);
        return new ListUserRegistrationsService($repository);
    }
    public function testListIsFullyLoaded()
    {
        $service = $this->buildSampleService();
        $collection = $service->query();

        $this->assertCount(13, $collection->asArray(), "Parsed list has 13 elements");
    }

    public function testListIsOrdered()
    {
        $service = $this->buildSampleService();
        $collection = $service->query();

        $orderedIds = array_column($collection->asArray(), 'id');
        $this->assertTrue($orderedIds == self::EXPECTED_ORDER, "List is ordered by name and surname");
    }

    public function testListFiltersCountries()
    {
        $service = $this->buildSampleService();
        $collection = $service->query(["countries"=>"JP,CN"]);

        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_COUNTRIES_CN_JP, "JP and CN countries are filtered out correctly.");
    }

    /**
     * Edge case - country filter is empty
     */
    public function testListFiltersNoCountry()
    {
        $service = $this->buildSampleService();
        $collection = $service->query(["countries"=>""]);

        $this->assertEmpty($collection->asArray(), "Empty list of countries leads to empty list of users.");
    }

    /**
     * Edge case - country filter contains all countries
     */
    public function testListFiltersAllCountriesJPorCN()
    {
        $service = $this->buildSampleService();
        $collection = $service->query(["countries"=>"JO,VN,RS,GR,CN,PH,MA,JP,SE,PL,US,AZ"]);

        $this->assertCount(13, $collection->asArray(), "Parsed list has 13 elements after filtering all existing countries");
    }

    /**
     * Edge case - activation length 0 day
     */
    public function testListFiltersActivationLength0()
    {
        $service = $this->buildSampleService();
        $collection = $service->query(["activation_length"=>0]);

        $this->assertCount(13, $collection->asArray(), "Parsed list has 13 elements after filtering activation length 0");
    }

    /**
     * Filter activation length 19 days
     */
    public function testListFiltersActivationLength19()
    {
        $service = $this->buildSampleService();
        $collection = $service->query(["activation_length"=>19]);

        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_ACTIVATION_LENGTH_19, "Activation length of 19 days is filtered out correctly.");
    }

    /**
     * Edge case - activation length 100 days
     */
    public function testListFiltersActivationLength100()
    {
        $service = $this->buildSampleService();
        $collection = $service->query(["activation_length"=>100]);

        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_ACTIVATION_LENGTH_100, "Activation length of 100 days is filtered out correctly.");
    }

    /**
     * Filter activation length 10 days and coutries
     */
    public function testListFiltersActivationLength19AndCountriesJPorCN()
    {
        $service = $this->buildSampleService();
        $collection = $service->query(["activation_length"=>19, "countries"=>"JP,CN"]);
        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19, "Activation length of 19 days is filtered out correctly.");
    }

    /**
     * Check that result does not change when previous queries have been run.
     */
    public function testConsecutiveQueriesAreIndependent()
    {
        $service = $this->buildSampleService();
        $service->query([ "countries"=>"US"]);
        $collection = $service->query(["activation_length"=>19, "countries"=>"JP,CN"]);
        $ids = array_column($collection->asArray(), 'id');
        sort($ids);
        $this->assertTrue($ids == self::EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19, "Activation length of 19 days is filtered out correctly.");
    }
}