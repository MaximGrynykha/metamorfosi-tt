<?php

namespace App\Internal;

enum Rule: string
{
    case REQUIRED = 'required';
    case EMAIL = 'email';
    case MIN = 'min';
    case MAX = 'max';
    case MATCH = 'match';
    case UNIQUE = 'unique';

    /** 
     * @return string
    */
    public function message(): string
    {
        return match ($this) {
            self::REQUIRED => 'This field is required',
            self::EMAIL => 'This field must be valid email address',
            self::MIN => 'Min length of this field must be {min}',
            self::MAX => 'Min length of this field must be {max}',
            self::MATCH => 'This field must be the same as {match}',
            self::UNIQUE => 'Record with this {field} already exists',
        };
    }
}