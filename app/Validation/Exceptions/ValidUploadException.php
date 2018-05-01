<?php
namespace App\Validation\Exceptions;

use Recpect\Validation\Exceptions\ValidationException;

class ValidUploadException extends ValidationException 
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Please upload a valid file'
        ],
    ];
}