<?php


namespace TestOrg\Tests\Domain;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Internet;
use Faker\Provider\Miscellaneous;
use Faker\Provider\Person;
use TestOrg\Domain\User;

class UserMother
{
    /** @var Generator */
    private static $faker;

    protected static function faker() : Generator
    {
        if (! isset(self::$faker)) {
            self::$faker = Factory::create();
        }
        return self::$faker;
    }

    public static function dummy()
    {
        return new User(
            "Bob",
            "Carr",
            "bob@carr.com",
            "ES"
        );
    }

    public static function random() : User
    {
        return new User(
            self::getRandomName(),
            self::getRandomSurname(),
            self::getRandomEmail(),
            self::getRandomCountryCode()
        );
    }

    protected static function getRandomName(): string
    {
        return
            rand(0, 1) ?
            Person::firstNameFemale() :
            Person::firstNameMale();
    }

    protected static function getRandomSurname(): string
    {
        return self::faker()->lastName;
    }

    protected static function getRandomEmail(): string
    {
        return Internet::freeEmailDomain();
    }

    protected static function getRandomCountryCode(): string
    {
        return Miscellaneous::countryCode();
    }
}
