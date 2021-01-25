<?php


namespace App\Application\Service;

use App\Domain\ListUserRegistrationRepository;
use App\Domain\UserRegistrationCollection;
use App\Domain\UserRegistrationCriteria;

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
