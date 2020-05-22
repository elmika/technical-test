<?php


namespace TestOrg\Tests\Domain;


use TestOrg\Domain\User;
use TestOrg\Domain\UserRegistration;

class UserRegistrationMother
{
    public static function dummy()
    {
        return new UserRegistration(
            1,
            new User("Bob", "Carr", "bob@carr.com", "ES"),
            new \DateTimeImmutable("2020-05-10")
        );
    }
}