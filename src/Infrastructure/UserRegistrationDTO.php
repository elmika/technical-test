<?php


namespace App\Infrastructure;

/**
 *
 * Just for semantic, I would call this UserRegistrationResponse, to clarify the intention of this class.
 * DTO is too generic: a Response should always be a DTO, but a DTO can be multiple things.
 *
 * Moreover, this object could perfectly live inside application layer, just near to who should produce it, that is the
 * use case that you call in your controller.
 *
 * src/Application/Service/ListUserRegistrations -> is a query you make to your system that internally uses some repo to
 * retrieve a collection of domain objects. Instead of returning domain object to controller, you can use DTOs once
 * again, and return a Response object to your controller. So infrastructure knows less about domain.
 *
 * src/Application/Service/UserRegistrationResponse -> this will take a single UserRegistration
 * src/Application/Service/UserRegistrationCollectionResponse -> this will take a collection of UserRegistration
 *
 * In the case you need it also for retrieving things from a persistence system, then you could have a mapper, like
 * Doctrine does. The name is quite self-explaining a broadly used. Probably it is just a case that here you can use the
 * same object for both purposes, but try to follow the rule of three by Fowler, since premature abstraction could be
 * misleading.
 */
class UserRegistrationDTO implements \JsonSerializable
{
    private int $id;
    private string $name;
    private string $surname;
    private string $email;
    private string $country;
    private string $createdAt;
    private string $activatedAt;
    private int $chargerID;

    public function __construct(
        int $id,
        string $name,
        string $surname,
        string $email,
        string $country,
        string $createdAt,
        string $activatedAt,
        int $chargerID
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->country = $country;
        $this->createdAt = $createdAt;
        $this->activatedAt = $activatedAt;
        $this->chargerID = $chargerID;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getActivatedAt(): string
    {
        return $this->activatedAt;
    }

    /**
     * @return int
     */
    public function getChargerID(): int
    {
        return $this->chargerID;
    }

    public function jsonSerialize()
    {
        $array = [
            "id" => $this->id,
            "name" => $this->name,
            "surname" => $this->surname,
            "email" => $this->email,
            "country" => $this->country,
            "createdAt" => $this->createdAt
        ];

        if (! is_null($this->activatedAt)) {
            $array["activatedAt"] = $this->activatedAt;
            $array["chargerID"] = $this->chargerID;
        }

        return $array;
    }
}
