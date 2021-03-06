<?php

namespace App\Controllers\User;

use App\Models\Student;
use App\Controllers\Controller;
use App\Models\Project\ProjectPartner;
use Illuminate\Database\QueryException as Exception;

class ProjectPartnerController extends Controller

{

    /**
     *
     *
     * @var [type]
     */
    protected $current_user;
    protected $partner;

    /**
     * Select project partner 
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function addPartner($request,$response,$args)
    {

        //project partner
        $partner = Student::find($args['id']);
        
        //pulling current student
        $current_user = $this->auth->user();


        //checking if the project partner is offering the same programme
        if($partner->course_id ==  $current_user->course_id)
        {
            $query = ProjectPartner::where('first_id',$current_user->student_number)->count();

            /**
             * is the current login student a project leader
             */
            if(!$query)
            {
                //check if the current student is in any project group
                $check_current_student = ProjectPartner::where('second_id',$current_user->student_number)->count();

                /**
                 *  current student have a project partner
                 */
                if($check_current_student)
                {
                   return $this->customRedirect($response,$current_user, ' you  already have a project group');
                }

                else
                {
                    
                    $select_partner = ProjectPartner::where('first_id',$partner->student_number)
                                                ->orWhere('second_id',$partner->student_number)
                                                ->count();
                   
                    /**
                     * is the selected student has a project group
                     */                     
                     if(!$select_partner)
                     {
                        return $this->createProject($response,$current_user,$partner);
                       
                     }
                     else
                     { 
                         return $this->customRedirect($response,$current_user,ucwords($partner->name).' already have a project partner');
                     }

                }

            }

            /**
             * CUrrent student is a project leader
             */
            elseif($query)

            {
                /**
                 * Checking for number of project partners for a project
                 */
                if($query<5)
                {
                     $select_student = ProjectPartner::where('second_id',$partner->student_number)->count();
                    
                     /**
                      * Is selected student already have a project partner
                      */
                    if($select_student == 0)
                    {
                      return  $this->createProject($response,$current_user,$partner);
                    }
                    
                    //selected student is  already have  in a group
                    else 
                    {;
                        /**
                         * is selected student  a project partner of the current student
                         */

                        $isPartner  = $this->isPartner($partner,$current_user);
                        
                        if($isPartner)
                        {
                            return $this->customRedirect($response,$current_user, ucwords($partner->name).'  is  already in a group');
                        }
                        else{
                            return $this->customRedirect($response,$current_user, ucwords($partner->name).' is  already in a group');
                        }     
    
                    }
                }

                else

                {
                    return $this->customRedirect($response,$current_user,'Maximum of 5 partners are allowed to work on a project');
                }
                
               
     
            }
                

        }

        else
        /**
         * select project partner student is offering a different programme
         */
         
        {
            return $this->customRedirect($response,$current_user,ucwords($partner->name).' is  offering a different programme');                                                                                                                                                  
        }
        
       
    }


    /**
     * This method creates a new partner
     *
     * @param [type] $current_user
     * @param [type] $partner
     * @return void
     */
    public function createProject($response, $current_user,$partner)
    {

        ProjectPartner::create([
            'first_id' => trim($current_user->student_number),
            'second_id' => trim($partner->student_number),
        ]);

        $this->container->flash->addMessage('success','Congrats! '.ucwords($partner->name).' is your new project partner');
        return $response->withRedirect($this->router->pathFor('student.index'));
    }

    public function customRedirect($response,$current_user,$message)
    {
        $this->container->flash->addMessage('danger','Dear '.ucwords($current_user->name).', '.$message);
        return  $response->withRedirect($this->router->pathFor('student.index'));

    }


    /**
     * This method checks  if the selected student is a  project partner  for the current login student
     *
     * @param [array] $partner
     * @param [array] $current_user
     * @return boolean
     */
    public function isPartner($partner,$current_user)
    {
       
        $isPartner = ProjectPartner::where('second_id',$partner->student_number)
                                ->where('first_id',$current_user->student_number)->get();

        return $isPartner;
    }

    /**
     * This method remove student project partner 
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function deletePartner($request,$response,$args)
    {

        $delete = ProjectPartner::find($args['id']);
        $delete->delete();

        $this->flash->addMessage('danger','Operation successfull');

        return $response->withRedirect($this->router->pathFor('dashboard'));

       
    }





}