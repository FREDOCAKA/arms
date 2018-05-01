<?php
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class CourseAvailableException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Course already exist.',
        ]
        ];
}