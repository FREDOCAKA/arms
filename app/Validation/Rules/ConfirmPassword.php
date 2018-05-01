<?php
namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class ConfirmPassword extends AbstractRule
{

    public function validate($input)
    {
        
        return $_POST['password'] === $_POST['confirm_password'];

    }

}