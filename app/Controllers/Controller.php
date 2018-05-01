<?php
namespace App\Controllers;

class Controller 

{

    protected $container;

    //constructor
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Binding the view to the contstructor
     */

    public function __get($property)
    {
        if($this->container->{$property})
        {
            return $this->container->{$property};
        }
    }



}