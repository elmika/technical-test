<?php


namespace App\Infrastructure;

use TestOrg\Domain\User;
use TestOrg\Domain\UserRegistration;

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
            $dto->getName(),
            $dto->getSurname(),
            $dto->getEmail(),
            $dto->getCountry()
        );

        return (new UserRegistration(
            $dto->getId(),
            $user,
            new \DateTimeImmutable($dto->getCreatedAt())
        ))->activate(
            $dto->getChargerID(),
            new \DateTimeImmutable($dto->getActivatedAt())
        );
    }
}
