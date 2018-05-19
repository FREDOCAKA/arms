<?php
/***
 * 
 * Handling authentication
 */
namespace  App\Auth;

use App\Models\Student;
use App\Models\Lecturer;

class Auth 
{

    protected $password;

    /**
     * Log out users
     *
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['role']);
        unset($_SESSION['approve']);
        // session_destroy();
    }
    
    /**
     * Current authenticated user
     *
     * @return  user details
     */
    public function user()
    {
        
        if($_SESSION['role']==1)
        {
            return Student::find($_SESSION['user']);
        }

         
        if($_SESSION['role']==2 OR  $_SESSION['role']==3)
        {
            return Lecturer::find($_SESSION['user']);
        }
        
      
    }
    
    /**
     * check if the user session isset
     *
     * @return void
     */
    public function check()
    {
        return isset($_SESSION['user']);
    }

    /**
     * check if the user role   session is set
     *
     * @return void
     */
    public function role()
    {
        return isset($_SESSION['role']);
    }
  
    /**
     * Attempt authentication
     *
     * @param [type] $email
     * @param [type] $password
     * @return void
     */
    public function attempt($email,$password)
    {

        $student  = Student::where('email',$email)->first();
        $lecturer = Lecturer::where('email',$email)->first();

        /**
         * Authenticating Students
         */
        if($student)
        {
            if(password_verify($password, $student->password))
            {
                $_SESSION['user']    = $student->id;
                $_SESSION['role']    = 1;
                return true; 
            }
            
        }

        /**
         * Authenticating Lecturers
         */

        if($lecturer->role==2)
        {
            if(password_verify($password, $lecturer->password))
            {
                if($lecturer->status == '1')
                {
                    $_SESSION['user']    = $lecturer->id;
                    $_SESSION['role']    = 2;
                    return true; 
                }

                $_SESSION['approve'] = 'approve';
                
                return true;
              
            }
            
        }

        /**
         * Authenticating Admin
         */
        if($lecturer->role == 3)
        {
            if(password_verify($password, $lecturer->password))
            {
                $_SESSION['user']    = $lecturer->id;
                $_SESSION['role']    = 3;
                return true; 
            }
        }

        return false;
      

    }

   /**
    * Checking if authenticated user is an admin or a lecturer
    *
    * @param [string] $password
    * @param [string] $role
    * @param [int] $role_id
    * @return void
    */
    public function checkLecturer($role_id)
    {
        if(password_verify($password, $lecturer->password))
        {
            $_SESSION['user']    = $lecturer->id;
            $_SESSION['role']    = $role_id;
            return true; 
        }
    }

    /**
     * Check if the login user is admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        $lecturer = Lecturer::find($_SESSION['user']);

        if($lecturer->role == '3')
        {
            return true;
        }

        return false;
    }
    
    public function isStudent()
    {
        $student = Student::find($_SESSION['user']);
        
        if($student->role == '1')
        {
            return true;
        }

        return false;

    }
}