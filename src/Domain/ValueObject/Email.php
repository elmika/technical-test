<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidValueException;

class Email extends StringValueObject
{
    /**
     * Email constructor.
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
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->throwInvalidValueException($value, Email::class);
        }
    }
}
