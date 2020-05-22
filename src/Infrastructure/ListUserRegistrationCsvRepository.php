<?php


namespace TestOrg\Infrastructure;

use App\Infrastructure\UserRegistrationAdapter;
use App\Infrastructure\UserRegistrationDTOAdapter;

use TestOrg\Domain\ListUserRegistrationRepository;
use TestOrg\Domain\UserRegistrationCollection;
use TestOrg\Domain\UserRegistrationCriteria;

class ListUserRegistrationCsvRepository implements ListUserRegistrationRepository
{
    private string $sourceFile;
    private UserRegistrationCollection $collection;

    /**
     * ListUserRegistrationCsvRepository constructor.
     * @param string $sourceFile location of csv file that we parse
     */
    public function __construct(string $sourceFile)
    {
        $this->sourceFile = $sourceFile;
    }

    /**
     * Read csv applying a given criteria
     * We may query several times with the same object
     * though the csv will still be read and parsed several times...
     * @todo store file once read and sorted so we do not load it several times
     *
     * @param UserRegistrationCriteria $criteria - an empty criteria will do nothing
     * @return UserRegistrationCollection
     */
    public function query(UserRegistrationCriteria $criteria = null):UserRegistrationCollection
    {
        $this->read();
        $this->collection->sortListByNameAndSurname();
        if (! is_null($criteria)) {
            $this->collection->applyFilterCriteria($criteria);
        }

        return $this->collection;
    }

    /**
     * Read CSV file from source, initialize our collection
     */
    private function read()
    {
        $this->collection = new UserRegistrationCollection();
        $registrations = file($this->sourceFile);

        foreach ($registrations as $line) {
            try {
                $dto = UserRegistrationDTOAdapter::fromCSV($line);
                $userRegistration = UserRegistrationAdapter::fromDTO($dto);
                $this->collection->append($userRegistration);
            } catch (\Exception $e) {
                error_log("Problem importing the following line from csv: ".$line);
            }
        }
    }
}
