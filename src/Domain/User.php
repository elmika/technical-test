<?php


namespace TestOrg\Domain;

use App\Domain\ValueObject\CountryCode;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Surname;

class User
{
    private Name $name;
    private Surname $surname;
    private Email $email;
    private CountryCode $countryCode;

    public function __construct(Name $name, Surname $surname, Email $email, CountryCode $countryCode)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->countryCode = $countryCode;
    }

    public function getName() : Name
    {
        return $this->name;
    }

    public function getSurname() : Surname
    {
        return $this->surname;
    }

    public function getEmail() : Email
    {
        return $this->email;
    }

    public function getCountryCode() : CountryCode
    {
        return $this->countryCode;
    }
    
    public function compareTo(User $b) : int
    {
        if ($this->surname->isEqualTo($b->getSurname())) {
            return $this->name->compareTo($b->getName());
        }
        return $this->surname->compareTo($b->getSurname());
    }
}
