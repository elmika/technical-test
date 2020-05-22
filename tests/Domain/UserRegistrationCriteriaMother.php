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



    public static function countriesUS()
    {
        return new UserRegistrationCriteria([
            "countries"=>"US"
        ]);
    }

    public static function countriesJPandCN()
    {
        return new UserRegistrationCriteria([
            "countries"=>"JP,CN"
        ]);
    }

    public static function countriesEmptyList()
    {
        return new UserRegistrationCriteria([
            "countries"=>""
        ]);
    }

    public static function countriesLongList()
    {
        return new UserRegistrationCriteria([
            "countries"=>"JO,VN,RS,GR,CN,PH,MA,JP,SE,PL,US,AZ"
        ]);
    }

    public static function activationLengthZero()
    {
        return new UserRegistrationCriteria([
            "activation_length"=>0
        ]);
    }

    public static function activationLength19()
    {
        return new UserRegistrationCriteria([
            "activation_length"=>19
        ]);
    }

    public static function activationLength100()
    {
        return new UserRegistrationCriteria([
            "activation_length"=>100
        ]);
    }

    public static function activationLength19AndCountriesJPandCN()
    {
        return new UserRegistrationCriteria([
            "activation_length"=>19,
            "countries"=>"JP,CN"
        ]);
    }

}