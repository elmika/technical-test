<?php


namespace TestOrg\Tests\Domain;

use TestOrg\Domain\UserRegistrationCollection;

class UserRegistrationCollectionMother
{
    public static function singleUser()
    {
        return new UserRegistrationCollection(
            [UserRegistrationMother::dummy()]
        );
    }
}
