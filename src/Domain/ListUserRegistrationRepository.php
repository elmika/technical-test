<?php


namespace App\Domain;


interface ListUserRegistrationRepository
{
    public function query(UserRegistrationCriteria $criteria): UserRegistrationCollection;
}