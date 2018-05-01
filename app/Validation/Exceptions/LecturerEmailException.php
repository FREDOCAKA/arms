<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException; 

class LecturerEmailException extends ValidationException
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email  already exist',
        ],
    ];
}