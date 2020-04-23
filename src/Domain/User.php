<?php


namespace TestOrg\Domain;


class User
{
    private $name;
    private $surname;
    private $email;
    private $countryCode;

    public function __construct($name, $surname, $email, $countryCode)
    {
        $this->name = (string)$name;
        $this->surname = (string)$surname;
        $this->email = (string)$email;
        $this->countryCode = (string)$countryCode;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }
    
    public function compareTo($b)
    {
        if($this->surname == $b->getSurname()) {
            return strcmp($this->name, $b->getName());
        }
        return strcmp($this->surname, $b->getSurname());
    }

}