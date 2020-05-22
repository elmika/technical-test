<?php

namespace App\Infrastructure;

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
}
