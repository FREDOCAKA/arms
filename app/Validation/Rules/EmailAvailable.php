<?php
/**
 * Email Available custom Rule
 */
namespace App\Validation\Rules;

use App\Models\Student;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
    /**
     * Validate method
     *
     * @param [string] $input
     * @return void
     */
    public function validate($input)
    {
      return  Student::where('email',$input)->count()===0;  
      
    }

}