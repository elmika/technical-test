<?php


namespace App\Infrastructure;

use App\Domain\ValueObject\ActivationDate;
use App\Domain\ValueObject\ChargerID;
use App\Domain\ValueObject\CountryCode;
use App\Domain\ValueObject\CreationDate;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Surname;
use App\Domain\ValueObject\UserRegistrationID;
use App\Domain\User;
use App\Domain\UserRegistration;

/**
 * Beware: this class is generating a side-effect. You ask for something, and instead on only returning it, you also
 * change it, since you are activating a user. You really want to avoid this. Maybe is out of scope, but try to separate
 * commands and queries. This DOES NOT mean doing CQRS, it just means CQS.
 */
class UserRegistrationAdapter
{
    /**
     * @param UserRegistrationDTO $dto
     * @return UserRegistration
     * @throws \Exception
     */
    public static function fromDTO(UserRegistrationDTO $dto) : UserRegistration
    {
        $user = new User(
            new Name($dto->getName()),
            new Surname($dto->getSurname()),
            new Email($dto->getEmail()),
            new CountryCode($dto->getCountry())
        );

        return (new UserRegistration(
            new UserRegistrationID($dto->getId()),
            $user,
            new CreationDate(new \DateTimeImmutable($dto->getCreatedAt()))
        ))->activate(
            new ChargerID($dto->getChargerID()),
            new ActivationDate(new \DateTimeImmutable($dto->getActivatedAt()))
        );
    }
}
