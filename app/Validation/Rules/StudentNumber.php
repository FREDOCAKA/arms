<?php

namespace App\Validation\Rules;

use App\Models\Student;
use Respect\Validation\Rules\AbstractRule;

class StudentNumber extends AbstractRule
{
    public function validate($input)
    {
        return Student::where('student_number',$input)->count()==0;
    }
}