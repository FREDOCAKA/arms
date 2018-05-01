<?php
/**
 *  Handling all the routes
 */
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleware;

$app->get('/', 'HomeController:index')->setName('home');
// $get->get('/projects/index','HomeController:projects')->setName('home.projects');

/******************************************************* 
*
*Admin Routes
*
/******************************************************** */

$app->group('',function(){

 /**
 * Project routes
 */
$this->get('/project','ProjectController:index')->setName('project.index');
$this->get('/project/create','ProjectController:create')->setName('project.create');
$this->post('/project/create','ProjectController:postProject');
$this->delete('/project/{id}','ProjectController:deleteProject');
$this->get('/project/{id}','ProjectController:showProject')->setName('project.show');
$this->post('/project/{id}','ProjectController:fileDownload');
$this->get('/project/update/{id}','ProjectController:getUpdate')->setName('project.update');
$this->put('/project/update/{id}','ProjectController:updateProject');
$this->post('/project','ProjectController:search')->setName('project.search');

/**
 * Category routes
 */

 $this->get('/category','CategoryController:index')->setName('category.index');
 $this->get('/category/create','CategoryController:show')->setName('category.create');
 $this->post('/category/create','CategoryController:create');
 $this->delete('/category/{id}','CategoryController:deleteCategory')->setName('category.delete');
 $this->get('/category/update/{id}','CategoryController:getUpdate')->setName('category.update');
 $this->put('/category/update/{id}','CategoryController:update');

 /**
  * Coureses routes
  */

  $this->get('/courses','CourseController:index')->setName('course.index');
  $this->get('/course/create','CourseController:show')->setName('course.create');
  $this->post('/course/create','CourseController:create');
  $this->get('/course/update/{id}','CourseController:getUpdate')->setName('course.update');
  $this->put('/course/update/{id}','CourseController:update');
  $this->delete('/course/delete/{id}','CourseController:delete')->setName('course.delete');

  /**
   * Student routes
   */
  $this->get('/students','StudentController:index')->setName('student.index');
  $this->get('/student/{id}','StudentController:show')->setName('student.show');
  $this->delete('/student/{id}','StudentController:delete')->setName('student.delete');
  $this->post('/students','StudentController:search')->setName('student.search');

    /**
   * Student routes
   */
  $this->get('/lecturers','LecturerController:index')->setName('lecturer.index');
  $this->get('/lecturer/{id}','LecturerController:show')->setName('lecturer.show');
  $this->delete('/lecturer/{id}','LecturerController:delete')->setName('lecturer.delete');
  $this->post('/lecturer/{id}','LecturerController:approve')->setName('lecturer.approve');
  $this->post('/lecturers','LecturerController:search')->setName('lecturer.search');
  



})->add( new AdminMiddleware($container));


/**
 * Auth Routes
 */
$app->group('', function(){

    //logout
    $this->get('/auth/logout','LoginController:getLogout')->setName('logout');
    //dashboard
    $this->get('/dashboard','HomeController:getDashboard')->setName('dashboard');

    //profile
    $this->get('/profile/{id}','ProfileController:getProfile')->setName('profile');
    $this->put('/profile/{id}','ProfileController:updateStudent');

    //Reset password
    $this->get('/password','ProfileController:getPassword')->setName('password');
    $this->put('/password','ProfileController:updatePassword');


})->add( new AuthMiddleware($container));

/**
 * Guest Routes
 */
$app->group('', function(){
    // Registration routes  for students
    $this->get('/auth/signup','SignupController:getSignup')->setName('auth.signup');
    $this->post('/auth/signup','SignupController:postSignup');

    //Registration routes for lecturers
    $this->get('/auth/lecturer','SignupController:signupLecturer')->setName('auth.lecturer');
    $this->post('/auth/lecturer','SignupController:newLecturer');

    // Login routes
    $this->get('/auth/login','LoginController:getLogin')->setName('auth.login');
    $this->post('/auth/login','LoginController:postLogin');


    $this->get('/registration','SignupController:getRegistration')->setName('auth.register');

})->add( new GuestMiddleware($container));

