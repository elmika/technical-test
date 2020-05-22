<?php

namespace TestOrg\Tests\Domain;

use TestOrg\Domain\UserRegistrationCriteria;

class UserRegistrationCriteriaMother
{
    public static function empty()
    {
        return new UserRegistrationCriteria([]);
    }

    public static function dummy()
    {
        return new UserRegistrationCriteria([
                 'countries' => ["ES,FR,US"],
                 'activation_length' => 11,
                 'dummy_filter' => "dummy_value"
        ]);
    }

    public static function countries()
    {
        return new UserRegistrationCriteria([
            'countries' => ["ES", "FR", "US"]
        ]);
    }
}