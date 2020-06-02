<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidValueException;

/**
 * Class CountryCode
 * Two letters country code
 * @package App\Domain\ValueObject
 */
class CountryCode extends StringValueObject
{
    /**
     * CountryCode constructor.
     * @param string $value
     * @throws InvalidValueException
     */
    public function __construct(string $value)
    {
        $this->guard($value);
        parent::__construct($value);
    }

    /**
     * @param $value
     * @throws InvalidValueException
     */
    private function guard($value)
    {
        if (strlen($value) != 2) {
            $this->throwInvalidValueException($value, CountryCode::class);
        }
    }
}