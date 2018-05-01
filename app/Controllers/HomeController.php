<?php

namespace App\Controllers;

class HomeController extends Controller

{

    public function index($request,$response)
    {
        return $this->view->render($response,'home.twig');
    }


    /**
     * Dasboard
     */
    public function getDashboard($request,$response,$args)
    {
    
        return $this->view->render($response,'dashboard/dashboard.twig');
    }
}