<?php


namespace TestOrg\Domain;

class UserRegistration
{
    private $id;
    private $user;
    private $createdAt;
    private $activatedAt = null;
    private $chargerId = null;

    public function __construct($id, User $user, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->user = $user;
        $this->createdAt = $createdAt->setTime(0, 0, 0);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function hasId(int $id) : bool
    {
        return $this->id === $id;
    }
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isActivated(): bool
    {
        return ! is_null($this->activatedAt);
    }

    /**
     * @param string $chargerId
     * @param \DateTimeImmutable $activatedAt
     * @return $this
     */
    public function activate(string $chargerId, \DateTimeImmutable $activatedAt): self
    {
        $this->activatedAt = $activatedAt->setTime(0, 0, 0);
        $this->chargerId = $chargerId;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getActivatedAt(): \DateTimeImmutable
    {
        return $this->activatedAt;
    }

    /**
     * @return string
     */
    public function getChargerId()
    {
        return $this->chargerId;
    }

    /**
     * Difference between creation and activation date
     * Note: if registration has not been activated yet,
     * we return the difference between creation date and today
     *
     * @var int $minLength
     * @return int
     * @throws \Exception
     */
    public function isOverActivationLength(int $minLength): int
    {
        if ($this->isActivated()) {
            $activatedAt = $this->activatedAt;
        } else {
            $activatedAt = (new \DateTimeImmutable())->setTime(0, 0, 0);
        }

        $activationLengthDays = (int)$activatedAt->diff($this->createdAt)->format('%a');
        return $activationLengthDays >= $minLength;
    }

    /**
     * @param array $countries
     * @return bool true if user countries is in the above list
     */
    public function isWithinCountries(array $countries)
    {
        return in_array($this->getUser()->getCountryCode(), $countries);
    }

    /**
     * As used by sort algorithm
     *
     * @param UserRegistration $a
     * @param UserRegistration $b
     * @return int -1, 0 or 1, as strcmp
     */
    public static function compareUsers(UserRegistration $a, UserRegistration $b)
    {
        return $a->getUser()->compareTo($b->getUser());
    }
}
