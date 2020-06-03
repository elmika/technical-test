<?php

declare(strict_types = 1);

namespace App\Domain\ValueObject\Base;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidValueException;

/**
 * Class StringValueObject
 * Courtesy of CodelyTV, with some addons
 * @package App\Domain\ValueObject
 */
abstract class IntegerValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    /**
     * @param $value
     * @param $object
     * @throws InvalidValueException
     */
    protected function throwInvalidValueException(int $value, string $object)
    {
        throw new InvalidValueException(
            sprintf("%d is no a valid %s format.", $value, $object)
        );
    }

    public function isEqualTo(IntegerValueObject $b) : bool
    {
        if (get_class($this) !== get_class($b)) {
            return false;
        }

        return ($this->value == $b->value());
    }

    /**
     * @param IntegerValueObject $b
     * @return int -1 if inferior, 0 if equal, 1 if superior
     * @throws DomainException
     */
    public function compareTo(IntegerValueObject $b) : int
    {
        if (get_class($this) !== get_class($b)) {
            throw new DomainException("Two value objects of different types cannot be compared.");
        }

        return $this->value > $b->value() ? 1 : -1;
    }
}
