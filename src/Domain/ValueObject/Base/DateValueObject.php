<?php

declare(strict_types = 1);

namespace App\Domain\ValueObject\Base;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\InvalidValueException;

/**
 * Class DateValueObject
 * @package App\Domain\ValueObject
 */
abstract class DateValueObject
{
    protected \DateTimeImmutable $value;

    public function __construct(?\DateTimeInterface $value = null)
    {
        if (null === $value) {
            $value = new \DateTimeImmutable();
        }

        if ($value instanceof \DateTime) {
            $value = \DateTimeImmutable::createFromMutable($value);
        }
        $this->value = $value->setTime(0, 0, 0);
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value()->format("Y-m-d");
    }

    /**
     * @param $value
     * @param $objectName
     * @throws InvalidValueException
     */
    protected function throwInvalidValueException(string $value, string $objectName)
    {
        throw new InvalidValueException(
            sprintf("%s is no a valid %s format.", $value, $objectName)
        );
    }

    public function isEqualTo(DateValueObject $b) : bool
    {
        return $this->value == $b->value();
    }

    /**
     * @param DateValueObject $b
     * @return int as with strcmp, -1 if inferior, 0 if equal, 1 if superior
     * @throws DomainException
     */
    public function compareTo(DateValueObject $b) : int
    {
        if ($this->isEqualTo($b)) {
            return 0;
        }

        return $this->value > $b->value() ? 1 : -1;
    }

    /**
     * Number of days between two dates
     * @param DateValueObject $b
     * @return int
     */
    public function diffDays(DateValueObject $b) : int
    {
        return (int)$this->value->diff($b->value())->format('%a');
    }
}
