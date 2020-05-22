<?php


namespace TestOrg\Tests\Infrastructure;

use PHPUnit\Framework\TestCase;
use TestOrg\Domain\UserRegistrationCollection;
use TestOrg\Domain\UserRegistrationCriteria;
use TestOrg\Infrastructure\ListUserRegistrationCsvRepository;
use TestOrg\Tests\Domain\UserRegistrationCriteriaMother;

class ListUserRegistrationCsvRepositoryTest extends TestCase
{
    // private $service;
    private ListUserRegistrationCsvRepository $repository;
    private UserRegistrationCollection $collection;
    private UserRegistrationCriteria $criteria;

    // Sample data
    const USER_LIST_FILE=__DIR__."/../Data/test.csv";

    // Compiled expected results (ordered list of element ids, reordered incrementally to validate filters)
    const EXPECTED_ORDER=[7,11,2,12,1,8,13,9,5,10,6,3,4]; // compiled manually ndlr
    const EXPECTED_FILTERED_COUNTRIES_CN_JP=[5,7,9];
    const EXPECTED_FILTERED_ACTIVATION_LENGTH_19=[1,7,13];
    const EXPECTED_FILTERED_ACTIVATION_LENGTH_100=[];
    const EXPECTED_FILTERED_BOTH_CN_JP_5=[];
    const EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19=[7];

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ListUserRegistrationCsvRepository(self::USER_LIST_FILE);
        $this->collection = new UserRegistrationCollection();
        $this->criteria = UserRegistrationCriteriaMother::empty();
    }

    private function executeQueryWithParameters($parameters = []) : void
    {
        $criteria = new UserRegistrationCriteria($parameters);
        $this->collection =  $this->repository->query($criteria);
    }

    private function collectionMatches(array $expectedIds) : bool
    {
        foreach ($this->collection as $element) {
            $id = array_shift($expectedIds);
            if (! $element->hasId($id)) {
                return false;
            }
        }
        return count($expectedIds) == 0;
    }

    /**
     * Find if an element is in an array, and remove it if found
     *
     * @param int $element to search for
     * @param array $array that possibly contains element
     * @return bool true if element has been found and removed
     */
    private function findAndRemove(int $element, array &$array) : bool
    {
        $pos = array_search($element, $array);
        if ($pos === false) {
            return false;
        }
        unset($array[$pos]);
        return true;
    }

    /**
     * Check if unordered lists are a match
     *
     * @param UserRegistrationCollection $collection
     * @param array $expectedIds
     * @return bool
     */
    private function collectionContains(array $expectedIds) : bool
    {
        foreach ($this->collection as $registration) {
            if (! $this->findAndRemove(
                $registration->getId(),
                $expectedIds
            )) {
                return false;
            }
        }

        return count($expectedIds) == 0;
    }

    /**
     * @test
     */
    public function it_should_return_the_full_list_if_no_filter_is_specified()
    {
        $this->executeQueryWithParameters();

        $this->assertTrue(
            13 == $this->collection->count(),
            "Parsed list has 13 elements"
        );
    }

    /**
     * @test
     */
    public function it_should_order_list_elements_by_name_and_surname()
    {
        $this->executeQueryWithParameters();

        $this->assertTrue(
            $this->collectionMatches(self::EXPECTED_ORDER),
            "List is ordered by name and surname"
        );
    }

    /**
     * @test
     */
    public function it_should_filter_countries_specified_in_coutries_filter()
    {
        $this->executeQueryWithParameters(["countries"=>"JP,CN"]);

        $this->assertTrue(
            $this->collectionContains(self::EXPECTED_FILTERED_COUNTRIES_CN_JP),
            "JP and CN countries are filtered correctly."
        );
    }

    /**
    /* @test
     * Edge case - country filter is empty
     */
    public function it_should_return_empty_list_when_country_filter_is_set_to_empty_list()
    {
        $this->executeQueryWithParameters(["countries"=>""]);

        $this->assertTrue(
            0 == $this->collection->count(),
            "Empty list of countries leads to empty list of users."
        );
    }

    /**
    /* @test
     * Edge case - country filter contains all countries
     */
    public function it_should_return_all_registrations_when_country_filter_contains_all_countries()
    {
        $this->executeQueryWithParameters(["countries"=>"JO,VN,RS,GR,CN,PH,MA,JP,SE,PL,US,AZ"]);

        $this->assertTrue(
            13 == $this->collection->count(),
            "Parsed list has 13 elements after filtering all existing countries"
        );
    }

    /**
    /* @test
     * Edge case - activation length 0 day
     */
    public function it_should_return_all_registrations_when_activation_length_filter_is_0()
    {
        $this->executeQueryWithParameters(["activation_length"=>0]);

        $this->assertTrue(
            13 == $this->collection->count(),
            "Parsed list has 13 elements after filtering activation length 0"
        );
    }

    /**
     * @test
     * Filter activation length 19 days
     */
    public function it_should_apply_filter_correctly_when_activation_length_is_19_days()
    {
        $this->executeQueryWithParameters(["activation_length"=>19]);
        $this->assertTrue(
            $this->collectionContains(self::EXPECTED_FILTERED_ACTIVATION_LENGTH_19),
            "Activation length of 19 days is filtered out correctly."
        );
    }

    /**
     * @test
     * Edge case - activation length 100 days
     */
    public function it_should_show_all_registrations_when_activation_lenght_filter_is_100()
    {
        $this->executeQueryWithParameters(["activation_length"=>100]);

        $this->assertTrue(
            $this->collectionContains(self::EXPECTED_FILTERED_ACTIVATION_LENGTH_100),
            "Activation length of 100 days is filtered out correctly."
        );
    }

    /**
     * @test
     * Filter activation length 10 days and countries
     */
    public function it_should_combine_filters_correctly()
    {
        $this->executeQueryWithParameters(["activation_length"=>19, "countries"=>"JP,CN"]);

        $this->assertTrue(
            $this->collectionContains(self::EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19),
            "Activation length of 19 days is filtered out correctly."
        );
    }

    /**
     * @test
     * Check that result does not change when previous queries have been run.
     */
    public function it_should_execute_consecutive_queries_independently()
    {
        $this->executeQueryWithParameters([ "countries"=>"US"]);
        $this->executeQueryWithParameters(["activation_length"=>19, "countries"=>"JP,CN"]);

        $this->assertTrue(
            $this->collectionContains(self::EXPECTED_FILTERED_COUNTRIES_CN_JP_AND_ACTIVATION_LENGTH_19),
            "Activation length of 19 days is filtered out correctly."
        );
    }
}
