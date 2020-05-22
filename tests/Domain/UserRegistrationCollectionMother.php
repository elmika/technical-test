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

    public static function multipleUsers($number = 10)
    {
        $list = [];
        for ($k = 0; $k < $number; $k++) {
            $list[] = UserRegistrationMother::random();
        }
        return new UserRegistrationCollection(
            $list
        );
    }
}
