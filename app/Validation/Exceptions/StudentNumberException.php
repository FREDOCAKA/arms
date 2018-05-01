<?php 

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;
class StudentNumberException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Student number already exist',
        ],
    ];

}
