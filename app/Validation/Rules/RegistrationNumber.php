<?php
/**
 * Registration Number Available custom Rule
 */
namespace App\Validation\Rules;

use App\Models\Student;
use Respect\Validation\Rules\AbstractRule;

class RegistrationNumber extends AbstractRule
{

    public function validate($input)
    {
        return Student::where('registration_number',$input)->count()===0;

    }

}