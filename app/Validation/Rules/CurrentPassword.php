<?php

namespace App\Validation\Rules;

use App\Models\Lecturer;
use App\Models\Student;
use Respect\Validation\Rules\AbstractRule;

class CurrentPassword extends AbstractRule 
{

    protected $password;

    /**
     * Constructor
     *
     * @param [string] $password
     */
    public function __construct($password)
    {
        $this->password= $password;
    }
    /**
     * Get user current password
     *
     * @param [string] $input
     * @return void
     */
    public function validate($input)
    {
        return password_verify($input, $this->password);

    }

}