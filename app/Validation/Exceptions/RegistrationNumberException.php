<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class RegistrationNumberException extends ValidationException

{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Registration number already exist',
        ],
    ];
}