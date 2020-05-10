<?php


namespace TestOrg\Application\Service;

use TestOrg\Domain\ListUserRegistrationRepository;
use TestOrg\Domain\UserRegistrationCollection;
use TestOrg\Domain\UserRegistrationCriteria;

class ListUserRegistrations
{
    private $repository;

    /**
     * ListUserRegistrations constructor.
     * @param string $sourceFile location of csv file that we parse
     */
    public function __construct(ListUserRegistrationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * * @param array $parameters with keys countries and activation_length for filtering
     * @return UserRegistrationCollection
     */
    public function query(array $parameters = []): UserRegistrationCollection
    {
        $criteria = new UserRegistrationCriteria($parameters);
        return $this->repository->query($criteria);
    }
}
