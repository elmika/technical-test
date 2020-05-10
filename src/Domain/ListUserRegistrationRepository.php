<?php


namespace TestOrg\Domain;

interface ListUserRegistrationRepository
{
    public function query(UserRegistrationCriteria $criteria): UserRegistrationCollection;
}
