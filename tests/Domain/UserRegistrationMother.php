<?php

namespace TestOrg\Tests\Domain;

use Faker\Provider\Base;
use Faker\Provider\DateTime as FakerDateTime;
use TestOrg\Domain\UserRegistration;

class UserRegistrationMother
{
    public static function dummy()
    {
        return new UserRegistration(
            1,
            UserMother::dummy(),
            new \DateTimeImmutable("2020-05-10")
        );
    }

    public static function random()
    {
        return new UserRegistration(
            self::getRandomId(),
            UserMother::random(),
            self::getRandomDateInThePast()
        );
    }

    protected static function getRandomId(): int
    {
        return Base::randomNumber(6);
    }

    protected static function getRandomDateInThePast(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable(
            FakerDateTime::dateTimeBetween(
                '-2 months',
                'now',
                "Europe/Madrid"
            )
        );
    }
}
