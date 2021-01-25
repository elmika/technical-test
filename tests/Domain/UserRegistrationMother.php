<?php

namespace App\Tests\Domain;

use App\Domain\ValueObject\CreationDate;
use App\Domain\ValueObject\UserRegistrationID;
use Faker\Provider\Base;
use Faker\Provider\DateTime as FakerDateTime;
use App\Domain\User;
use App\Domain\UserRegistration;

class UserRegistrationMother
{
    public static function dummy()
    {
        return new UserRegistration(
            new UserRegistrationID(1),
            UserMother::dummy(),
            new CreationDate(new \DateTimeImmutable("2020-05-10"))
        );
    }

    public static function random()
    {
        return new UserRegistration(
            new UserRegistrationID(self::getRandomId()),
            UserMother::random(),
            new CreationDate(self::getRandomDateInThePast())
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
