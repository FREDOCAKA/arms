<?php
namespace App\Middleware;

class AdminMiddleware extends Middleware 
{

    public function __invoke($request,$response,$next)
    {
      
        if(!$this->container->auth->isAdmin())
        {
            return $this->container->view->render($response,'home.twig');
            
        }

        $response = $next($request,$response);
        return $response;
    }
}