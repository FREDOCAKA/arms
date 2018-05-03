<?php

/**
 * Bootstraping the application
 */
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors','On');


 require __DIR__ .'/../vendor/autoload.php';

 use Respect\Validation\Validator as v;
 use Illuminate\Pagination\Paginator;

 $app = new \Slim\App([
    'settings'=> [

        'displayErrorDetails' => true,

        'db' => [
            'driver'         => 'mysql',
            'host'           => 'localhost',
            'database'       => 'arms',
            'username'       =>'root',
            'password'       => 'toor',
            'charset'        =>'utf8',
            'collation'      =>'utf8_unicode_ci',
            'prefix'         => ''
        ]
    ]
 ]);




// Initilaizing the container

$container = $app->getContainer();


 /**
  * Flash message class
  */

  $container['flash'] = function($container)
  {
      return new \Slim\Flash\Messages;
  };


/**
 * 
 * Setting up twig template engine
 * 
 */
$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/Views',[
        'cache'=> false,
    ]);

    //Adding twig extension
    $view->addEXtension( new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    //setting global variables
    $view->getEnvironment()->addGlobal('auth',[
        'user'    => $container->auth->user(),
        'check'   => $container->auth->check(),
        'role'    => $container->auth->role(),
    ]);

    //flash messages
    $view->getEnvironment()->addGlobal('flash',$container->flash);
    $view->getEnvironment()->addGlobal('links',$container->links);

    $view->getEnvironment()->addGlobal('helper',[
        'category' => $container->helper->allCategory(),
        'project'  => $container->helper->projectCategory(),
        'course'   => $container->helper->allCourses(),
    ]);
   

    return $view;
};

/***
 * 
 * Attaching the auth class
 */

 $container['auth'] = function($container)
 {
     return new \App\Auth\Auth;
 };

 /**
  * Pagination links
  */

  $container['links'] = function($container)
  {
      return new \Illuminate\Pagination\Paginator;
  };

/**
 * 
 * Adding slim csrf
 * 
 */

 $container['csrf'] = function($container)
 {
     return new \Slim\Csrf\Guard;
 };

 
/**
 * 
 * Binding controllers to the container
 * 
 */

 $container['HomeController'] = function($container){
     return new \App\Controllers\HomeController($container);
 };

 /**
  * Authentication controllers
  */

  $container['LoginController'] = function($container)
  {
      return new \App\Controllers\AuthController\LoginController($container);
  };

  $container['SignupController'] = function($container){
      return new \App\Controllers\AuthController\SignupController($container);
  };

/**
 * Profile controller
 */

 $container['ProfileController'] = function($container) {
     return new \App\Controllers\ProfileController($container);
 };

 /**
  * ProjectController
  */

  $container['ProjectController'] = function($container)
  {
      return new \App\Controllers\Project\ProjectController($container);
  };

  $container['CourseController'] = function($container)
  {
      return new \App\Controllers\Project\CourseController($container);
  };

  /**
   * Category controller
   */

   $container['CategoryController'] = function($container){
       return new \App\Controllers\Project\CategoryController($container);
   };

   $container['ProjectPartnerController'] = function($container){
        return new \App\Controllers\User\ProjectPartnerController($container);
   };

   /**
    * Student Controller
    */
   $container['StudentController'] = function($container)
   {
        return new \App\Controllers\User\StudentController($container);
   };

   $container['LecturerController'] = function($container)
   {
        return new \App\Controllers\User\LecturerController($container);
   };

  $container['helper'] = function($container)
  {
      return new \App\Helpers\Helper;
  };

 /**
  **Setting up eloquent 
  *
  */

  $capsule =  new \Illuminate\Database\Capsule\Manager;
  $capsule->addConnection($container['settings']['db']);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

  $container['db'] = function($container) use ($capsule)
  {
      return $capsule;
  };

  /**
   * 
   * Handling validation
   */
$container['validator'] = function($container){
    return new \App\Validation\Validator;

};

/***
 * Upload Image Helper class
 */
$container['MyFiles'] = function($container){
    return new \App\Helpers\MyFiles;
};

/**
 * Middlewares
 */

 $app->add( new \App\Middleware\InputErrorsMiddleware($container));
 $app->add( new \App\Middleware\OldInputMiddleware($container));
 $app->add( new \App\Middleware\CsrfViewMiddleware($container));

 
 $app->add($container->csrf);
 /**
  * Initializing Respect custom validation Rules
  */
  v::with("App\\Validation\\Rules\\");

 require_once __DIR__ .'/../app/routes.php';