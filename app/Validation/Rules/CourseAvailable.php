<?php
namespace App\Validation\Rules;

use App\Models\Project\Course;

use Respect\Validation\Rules\AbstractRule;

class CourseAvailable extends AbstractRule

{
    public function validate($input)
    {
        return Course::where('course_name',$input)->count()===0;
    }
}