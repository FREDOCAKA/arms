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
        $args = $this->auth->isAdmin();
        return $this->view->render($response,'dashboard.twig');
    }
}