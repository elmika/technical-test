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
     * @param ListUserRegistrationRepository $repository
     */
    public function __construct(ListUserRegistrationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserRegistrationCriteria $criteria
     * @return UserRegistrationCollection
     */
    public function query(UserRegistrationCriteria $criteria): UserRegistrationCollection
    {
        return $this->repository->query($criteria);
    }
}
