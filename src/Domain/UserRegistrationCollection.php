<?php


namespace App\Domain;

class UserRegistrationCollection extends \ArrayObject
{
    public function offsetSet($index, $newValue)
    {
        if (!is_a($newValue, UserRegistration::class)) {
            throw new \InvalidArgumentException(
                "Values in a User Registration Collection must be of type User Registration"
            );
        }

        parent::offsetSet($index, $newValue);
    }

    public function applyFilterCriteria(UserRegistrationCriteria $criteria)
    {
        // This is a workaround for a ugly spl bug here...
        foreach ($this->getArrayCopy() as $key => $registration) {
            if (!$criteria->validates($registration)) {
                $this->offsetUnset($key);
                continue;
            }
        }
    }

    /**
     * Order list by client name and surname
     */
    public function sortListByNameAndSurname(): void
    {
        $this->uasort([UserRegistration::class, "compareUsers"]);
    }
}
