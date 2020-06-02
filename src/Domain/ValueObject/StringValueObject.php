<?php

declare(strict_types = 1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidValueException;

/**
 * Class StringValueObject
 * Courtesy of CodelyTV, with some addons
 * @package App\Domain\ValueObject
 */
abstract class StringValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @param $value
     * @param $object
     * @throws InvalidValueException
     */
    protected function throwInvalidValueException($value, $object)
    {
        throw new InvalidValueException(
            sprintf("%s is no a valid %s format.", $value, $object)
        );
    }

    public function isEqualTo(StringValueObject $b) : bool
    {
        if (get_class($this) !== get_class($b)) {
            return false;
        }

        return (0 === strcmp($this->value, $b->value()));
    }

    /**
     * @param StringValueObject $b
     * @return int as with strcmp, -1 if inferior, 0 if equal, 1 if superior
     * @throws DomainException
     */
    public function compareTo(StringValueObject $b) : int
    {
        if (get_class($this) !== get_class($b)) {
            throw new DomainException("Two value objects of different types cannot be compared.");
        }

        return strcmp($this->value, $b->value());
    }
}
