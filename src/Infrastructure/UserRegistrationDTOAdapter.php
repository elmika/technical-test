<?php

namespace App\Infrastructure;

use App\Domain\UserRegistration;

/**
 * I tend to understand that an adapter is for incoming data, that means that could work as a piece for your
 * anti-corruption layer. For example, you have a User object coming from AWS sdk and you want to translate that user to
 * your domain without being coupled to aws -> you use an adapter.
 */
class UserRegistrationDTOAdapter
{
    const CSV_HEADERS = ["id", "name", "surname", "email", "country", "createdAt", "activatedAt", "chargerID"];

    /**
     * @param string $line one line of the full csv file - separated by comma
     * @return UserRegistrationDTO
     */
    public static function fromCSV(string $line) : UserRegistrationDTO
    {
        $aLine = explode(",", $line);
        $registration = array_combine(self::CSV_HEADERS, $aLine);
        return new UserRegistrationDTO(
            (int) $registration["id"],
            $registration["name"],
            $registration["surname"],
            $registration["email"],
            $registration["country"],
            $registration["createdAt"],
            $registration["activatedAt"],
            (int) $registration["chargerID"]
        );
    }

    public static function fromDomain(UserRegistration $registration) : UserRegistrationDTO
    {
        return new UserRegistrationDTO(
            $registration->getId()->value(),
            $registration->getUser()->getName(),
            $registration->getUser()->getSurname(),
            $registration->getUser()->getEmail(),
            $registration->getUser()->getCountryCode(),
            $registration->getCreatedAt(),
            $registration->isActivated() ? $registration->getActivatedAt() : null,
            $registration->isActivated() ? $registration->getChargerId()->value() : null
        );
    }
}
