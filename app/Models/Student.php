<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model 

{
    protected $fillable = [
        'name',
        'email',
        'password',
        'student_number',
        'registration_number',
        'course_id'
    ];
}
