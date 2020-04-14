<?php


namespace App\Domain;

class UserRegistrationCriteria
{
    /**
     * @var array list of countries accepted by our filter
     */
    private $countries;

    /**
     * @var int shorter time of activation we are interested to see
     */
    private $activationLength;

    /**
     * UserRegistrationCriteria constructor.
     * @param array $parameters with optional keys countries and activation_length for filtering
     */
    public function __construct(array $parameters)
    {
        if(array_key_exists('countries', $parameters))
        {
            $countries = explode(",", $parameters['countries']);
            $this->addCountriesFilter($countries);
        }

        if(array_key_exists('activation_length', $parameters))
        {
            $this->addActivationLengthFilter((int)$parameters['activation_length']);
        }
    }

    public function addCountriesFilter(array $countries)
    {
        $this->countries = $countries;
    }

    public function addActivationLengthFilter($length)
    {
        $this->activationLength = $length;
    }

    private function hasActivationLengthFilter()
    {
        return ! is_null($this->activationLength);
    }

    private function hasCountriesFilter()
    {
        return ! is_null($this->countries);
    }

    /**
     * Apply filters to one User Registration
     *
     * @param UserRegistration $registration
     * @return bool true if registration should be in final list
     * @throws \Exception
     */
    public function validates(UserRegistration $registration):bool
    {
        // we are not a listed country
        if($this->hasCountriesFilter()
            && ! $registration->isWithinCountries($this->countries))
        {
            return false;
        }

        // we are below specified activation length
        if($this->hasActivationLengthFilter()
            && ! $registration->isOverActivationLength($this->activationLength) )
        {
                return false;
        }

        return true;
    }
}