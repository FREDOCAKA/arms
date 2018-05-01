<?php
/***
 * 
 * Lecturer email Avalilabe validtaion
 */
 namespace App\Validation\Rules;

 use App\Models\Lecturer;
 use Respect\Validation\Rules\AbstractRule;

 class LecturerEmail extends AbstractRule

 {
     /**
      * validate method
      *
      * @param [string] $input
      * @return void
      */
     public function validate($input)
     {
         return Lecturer::where('email',$input)->count()===0;
     }

 }