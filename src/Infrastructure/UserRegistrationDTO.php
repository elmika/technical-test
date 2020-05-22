<?php


namespace App\Infrastructure;

class UserRegistrationDTO
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
}
