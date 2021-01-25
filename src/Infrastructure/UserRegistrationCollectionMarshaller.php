<?php

namespace App\Infrastructure;

use App\Domain\UserRegistrationCollection;

class UserRegistrationCollectionMarshaller
{
    /**
     * @param UserRegistrationCollection $collection
     * @return array of serializable UserRegistrationDTO
     */
    public static function toArray(UserRegistrationCollection $collection): array
    {
        $list = [];
        foreach ($collection as $userRegistration) {
            $list[] = UserRegistrationDTOAdapter::fromDomain($userRegistration);
        }
        return ["item" => $list];
    }
}
