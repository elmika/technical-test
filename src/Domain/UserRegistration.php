<?php


namespace TestOrg\Domain;

use App\Domain\ValueObject\ActivationDate;
use App\Domain\ValueObject\ChargerID;
use App\Domain\ValueObject\CreationDate;
use App\Domain\ValueObject\UserRegistrationID;

class UserRegistration
{
    private UserRegistrationID $id;
    private User $user;
    private CreationDate $createdAt;
    private ?ActivationDate $activatedAt = null;
    private ?ChargerID $chargerId = null;

    public function __construct(UserRegistrationID $id, User $user, CreationDate $createdAt)
    {
        $this->id = $id;
        $this->user = $user;
        $this->createdAt = $createdAt;
    }

    public function getId() : UserRegistrationID
    {
        return $this->id;
    }

    public function hasId(UserRegistrationID $id) : bool
    {
        return $this->id->isEqualTo($id);
    }
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function getCreatedAt(): CreationDate
    {
        return $this->createdAt;
    }

    public function isActivated(): bool
    {
        return ! is_null($this->activatedAt);
    }

    /**
     * @param ChargerID $chargerId
     * @param ActivationDate $activatedAt
     * @return $this
     */
    public function activate(ChargerID $chargerId, ActivationDate $activatedAt): self
    {
        $this->activatedAt = $activatedAt;
        $this->chargerId = $chargerId;
        return $this;
    }

    public function getActivatedAt(): ActivationDate
    {
        return $this->activatedAt;
    }

    public function getChargerId() : ChargerID
    {
        return $this->chargerId;
    }

    /**
     * Difference between creation and activation date
     * Note: if registration has not been activated yet,
     * we return the difference between creation date and today
     *
     * @return bool
     * @throws \Exception
     * @var int $minLength
     */
    public function isOverActivationLength(int $minLength): bool
    {
        if ($this->isActivated()) {
            $activatedAt = $this->activatedAt;
        } else {
            $activatedAt = new ActivationDate();
        }

        $activationLength = $activatedAt->diffDays($this->createdAt);
        return $activationLength >= $minLength;
    }

    /**
     * @param array $countries
     * @return bool true if user countries is in the above list
     */
    public function isWithinCountries(array $countries)
    {
        $thisCountryCode = $this->getUser()->getCountryCode();
        foreach ($countries as $countryCode) {
            if ($thisCountryCode->isEqualTo($countryCode)) {
                return true;
            }
        }
        return false;
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
