<?php


namespace App\Application;

use App\Domain\UserRegistrationCriteria;
use App\Infrastructure\ListUserRegistrationCsvRepository;

class ListUserRegistrationsService
{
    private $repository;

    /**
     * ListUserRegistrationsService constructor.
     * @param string $sourceFile location of csv file that we parse
     */
    public function __construct(string $sourceFile)
    {
        $this->repository = new ListUserRegistrationCsvRepository($sourceFile);
    }

    /**
     * @param array $parameters with keys countries and activation_length for filtering
     */
    public function query(array $parameters)
    {
        $criteria = new UserRegistrationCriteria($parameters);
        $this->repository->query($criteria);
    }

    public function asArray()
    {
        return $this->repository->asArray();
    }
}