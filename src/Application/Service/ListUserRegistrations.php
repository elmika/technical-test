<?php


namespace App\Application\Service;

use App\Domain\ListUserRegistrationRepository;
use App\Domain\UserRegistrationCollection;
use App\Domain\UserRegistrationCriteria;

/**
 * Here I suggest to receive a ListUserRegistrationsQuery DTO and instantiate the criteria from that plain data.
 * Another thing you could do, is to define a UserRegistrationCollectionResponse, that is another DTO that implements
 * the JsonSerializable interface. Not necessary, just an idea.
 */
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
