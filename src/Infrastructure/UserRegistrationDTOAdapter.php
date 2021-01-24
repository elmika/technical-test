<?php

namespace App\Infrastructure;

use App\Domain\UserRegistration;

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
            $registration->getId(),
            $registration->getUser()->getName(),
            $registration->getUser()->getSurname(),
            $registration->getUser()->getEmail(),
            $registration->getUser()->getCountryCode(),
            $registration->getCreatedAt()->format("Y-m-d"),
            $registration->isActivated() ? $registration->getActivatedAt()->format("Y-m-d") : null,
            $registration->isActivated() ? $registration->getChargerId() : null
        );
    }
}
