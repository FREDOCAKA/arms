<?php
/**
 * 
 * Middleware for students, lecturers and admin roles
 */
namespace App\Middleware;

class RolesMiddleware extends  Middleware
{
    
    public function __invoke($request,$response,$next){
        $response = $next($request,$response);
        return $respone;
    }
   
}