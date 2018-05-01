<?php 

namespace App\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use Respect\Validation\Validator as v;
class ProfileController extends Controller 

{
    /**
     * Getting profile page
     *
     * @param [array] $request
     * @param [array] $respone
     * @return void
     */
    public function getProfile($request,$respone, $args )
    {   

        $course = $this->db->table('courses')->leftjoin('students','courses.id','=','students.course_id')
                            ->where('students.id',$_SESSION['user'])->first();
      
        return $this->view->render($respone,'profile/profile.twig',
                                         ['id'=> $args['id'],
                                          'course' => $course]);
    }
    
    /**
     * Update students information
     *
     * @param [array] $request
     * @param [array] $respone
     * @return void
     */

    public function updateStudent($request,$respone, array $args)
    {
        $student  = Student::find($args['id']);
    
        $student->update([
            'name' => $request->getParam('name')
        ]);

        $this->flash->addMessage('success','You have successfully updated your account');

        return $respone->withRedirect($this->router->pathFor('profile', ['id'=>$args['id']] ));     
    }

    /**
     * Get Password
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function getPassword($request,$response)
    {
        return $this->view->render($response,'profile/password.twig');
     }
    
    /**
     * update password
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function updatePassword($request,$response)
    {

        /**
         * Handling validation
         */

         $validation = $this->validator->validate($request,[
            'current_password' => v::notEmpty()->currentPassword($this->auth->user()->password),
            'password'         => v::notEmpty()->confirmPassword(),
         ]);

         if($validation->failed())
         {
             return $response->withRedirect($this->router->pathFor('password'));
         }

        //checking for user roles
        if( $_SESSION['role']==1)
        {
            $student = Student::find($_SESSION['user']);
            $student->update([
                'password' => password_hash($request->getParam('password'),PASSWORD_DEFAULT) ,
            ]); 
            $this->flash->addMessage('success','You have successfully changed your password'); 
            return $response->withRedirect($this->router->pathFor('password'));         
        }

        elseif ($_SESSION['role']==2 OR $_SESSION['role']== 3)
        {
            $lecturer = Lecturer::find($_SESSION['user']);
            $lecturer->update([
                'password' => password_hash($request->getParam('password'),PASSWORD_DEFAULT) ,
            ]); 
            $this->flash->addMessage('success','You have successfully changed your password');  
            return $response->withRedirect($this->router->pathFor('password'));
        }
        else
        {
            return $response->withRedirect($this->router->pathFor('password'));
        }
       
    }


}