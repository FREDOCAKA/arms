<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator 

{

    protected $errors;
    /**
     * validate method
     *
     * @param [type] $request
     * @param arry $rules
     * @return void
     */
    public function validate($request, array $rules)
    {
        //looping through all the rules
        foreach( $rules as $field => $rule)
        {
            try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            }
            catch(NestedValidationException $e)
            {

                $this->errors[$field] = $e->getMessages();
            }   

        }
        $_SESSION['errors'] = $this->errors;

        return $this;

    }

    /**
     * Failed method
     */

     public function failed()
     {
         return !empty($this->errors);
     }

}