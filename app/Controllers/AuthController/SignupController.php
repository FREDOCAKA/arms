<?php
namespace App\Controllers\AuthController;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Project\Course;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class  SignupController extends Controller 

{

      /**
       * 
       * Sign Up page
       * 
       */

      public function getRegistration ($request,$response)
      {
          return $this->view->render($response,'auth/registration.twig');
      }

    /**
     * Getting student  signup page
     */

     public function getSignup($request,$response,$args)
     {
         $args = Course::all();

         return $this->view->render($response,'auth/signup.twig',[
             'courses' => $args,
         ]);
     }

     /***
      * Creating a new  student
      */
      public function postSignup($request,$response,$args)
      {
          $validation = $this->validator->validate($request,[
            'name'                => v::notEmpty()->alpha(),
            'email'               => v::notEmpty()->email()->emailAvailable()->lecturerEmail(),
            'registration_number' => v::notEmpty()->registrationNumber(),
            'student_number'      => v::noWhitespace()->numeric()->studentNumber(),
            'course_id'           => v::notEmpty(),
            'password'            => v::notEmpty()->confirmPassword(),
          ]);

          //If validation has failed

          if($validation->failed())
          {
              return $response->withRedirect($this->router->pathFor('auth.signup'));
          }

        // Registering user
        Student::create([
            'name'                    => $request->getParam('name'),
            'email'                   => $request->getParam('email'),
            'registration_number'     => $request->getParam('registration_number'),
            'student_number'          => $request->getParam('student_number'),
            'course_id'               => $request->getParam('course_id'),
            'password'                => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        ]);

    
        
        //adding flash message
        $this->flash->addMessage('success','You have successfully created your account. Please login');
 
        return $response->withRedirect($this->router->pathFor('auth.login'));

      }


      /***
       * 
       * Creating a new Lecturere
       * 
       * 
       */
      public function signupLecturer($request,$response)
      {
          return $this->view->render($response,'auth/newlecturer.twig');
      }

      public function newLecturer($request,$response)
      {
          /**
           * Handling validation
           */
          $validate = $this->validator->validate($request,[
              'name'      => v::notEmpty()->alpha(),
              'email'     => v::email()->lecturerEmail()->emailAvailable(),
              'password'  => v::notEmpty()->confirmPassword()
          ]);

          if($validate->failed())
          {
              return $response->withRedirect($this->router->pathFor('auth.lecturer'));
          }

          /**
           * creating a new record
           */

           Lecturer::create([
               'name'    => $request->getParam('name'),
               'email'   => $request->getParam('email'),
               'password'=> password_hash($request->getParam('password'),PASSWORD_DEFAULT),
               'role_id' => 2
           ]);

           $this->flash->addMessage('success','You have successfully created your account. Please login');

           return $response->withRedirect($this->router->pathFor('auth.login'));
      }

    
}