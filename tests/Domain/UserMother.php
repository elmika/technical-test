<?php


namespace App\Tests\Domain;

use App\Domain\ValueObject\CountryCode;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Surname;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Internet;
use Faker\Provider\Miscellaneous;
use Faker\Provider\Person;
use App\Domain\User;

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
            new Name("Bob"),
            new Surname("Carr"),
            new Email("bob@carr.com"),
            new CountryCode("ES")
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

    protected static function getRandomName(): Name
    {
        return new Name(
            rand(0, 1) ?
            Person::firstNameFemale() :
            Person::firstNameMale()
        );
    }

    protected static function getRandomSurname(): Surname
    {
        return new Surname(self::faker()->lastName);
    }

    protected static function getRandomEmail(): Email
    {
        return new Email(
            self::getRandomName()->value(). ".".
            self::getRandomSurname()->value(). "@".
            Internet::freeEmailDomain()
        );
    }

    protected static function getRandomCountryCode(): CountryCode
    {
        return new CountryCode(Miscellaneous::countryCode());
    }
}
