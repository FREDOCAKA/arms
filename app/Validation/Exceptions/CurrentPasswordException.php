<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class CurrentPasswordException extends ValidationException

{
    /**
     * Exception Error
     *
     * @var array
     */
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Incorrect Current Password. Please try again',
        ]
    ];
}