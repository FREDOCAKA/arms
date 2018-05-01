<?php
/**
 * Middleware to display errors on the inputs when validation failed
 */

namespace App\Middleware;

class InputErrorsMiddleware extends Middleware
{

    public function __invoke($request,$respone,$next)
    {

        $this->container->view->getEnvironment()->addGlobal('errors',$_SESSION['errors']);

        unset($_SESSION['errors']);

        //calling the next middleware
        $respone = $next($request,$respone);
        return $respone;
    }
}