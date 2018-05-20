<?php 

namespace App\Middleware;

class StudentMiddleware extends Middleware

{

    /**
     * This middleware checks if the login user
     * is a student
     */
    public function __invoke($request,$response,$next)
    {
        

        if(!$this->container->auth->isStudent() && $this->container->auth->check()){
            

            // return $this->container->view->render($response,'home.twig');
        }

 
        $response = $next($request,$response);
        return $response;

    }
}