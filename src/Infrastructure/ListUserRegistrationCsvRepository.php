<?php


namespace App\Infrastructure;


use App\Domain\ListUserRegistrationRepository;
use App\Domain\UserRegistrationCollection;
use App\Domain\UserRegistrationCriteria;

use App\Domain\User;
use App\Domain\UserRegistration;

class ListUserRegistrationCsvRepository implements ListUserRegistrationRepository
{
    const HEADERS = ["id", "name", "surname", "email", "country", "createdAt", "activatedAt", "chargerID"];
    private $sourceFile;

    /**
     * @var UserRegistrationCollection
     */
    private $collection;

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
    public function query(UserRegistrationCriteria $criteria=null):UserRegistrationCollection
    {
        $this->read();
        $this->collection->sortListByNameAndSurname();
        if(! is_null($criteria))
        {
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
        $registrations = array_map('str_getcsv', file($this->sourceFile));
        foreach($registrations as $line)
        {
            // Create array with keys defined in headers
            $registration = array_combine(self::HEADERS, $line);
            $this->readLine($registration);
        }
    }

    /**
     * @param array $registration associative array with keys defined in self::HEADERS
     * @throws \Exception
     */
    private function readLine(array $registration)
    {
        $user = new User(
            $registration["name"],
            $registration["surname"],
            $registration["email"],
            $registration["country"]
        );

        $userRegistration = (new UserRegistration(
            $registration["id"],
            $user,
            new \DateTimeImmutable($registration["createdAt"])
        ))->activate(
            $registration["chargerID"],
            new \DateTimeImmutable($registration["activatedAt"])
        );

        $this->collection->append($userRegistration);
    }
}