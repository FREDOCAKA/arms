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

        // var_dump($partner->course_id); 
        // var_dump($current_user->course_id);
        // die();

        //checking if the project partner is offering the same programme
        if($partner->course_id ==  $current_user->course_id)
        {
            $query = ProjectPartner::where('first_id',$current_user->student_number)->count();

            //check if the current student is the project leader
            if(!$query)
            {
                //check if the current student is in any project group
                $check_current_student = ProjectPartner::where('second_id',$current_user->student_number)->count();

        
                if($check_current_student)
                {
                    $this->container->flash->addMessage('danger','Hello '.ucwords($current_user->name).', you already have a project partner');
                    return  $response->withRedirect($this->router->pathFor('student.index'));
                }

                else
                {
                    //check if the selected student is already in a group
                    $select_partner = ProjectPartner::where('first_id',$partner->student_number)
                                                ->orWhere('second_id',$partner->student_number)
                                                ->count();
                     if(!$select_partner)
                     {
                            ProjectPartner::create([
                                'first_id' => trim($current_user->student_number),
                                'second_id' => trim($partner->student_number),
                            ]);
        
                            $this->container->flash->addMessage('success','Congrats! '.ucwords($partner->name).' is your new project partner');
                            return  $response->withRedirect($this->router->pathFor('student.index'));
                     }
                    // select student already have a project partner
                 
                    $this->container->flash->addMessage('danger','Hello '.ucwords($current_user->name).'You already have a project partner');
                    return  $response->withRedirect($this->router->pathFor('student.index'));

                }

            }

            elseif($query <= 5)

            {
                
                //check if the current student is in any project group
                $select_student = ProjectPartner::where('second_id',$partner->student_number)->count();

                if($select_student == 0)
                {
                    echo  $select_student;
                    die();
                    ProjectPartner::create([
                        'first_id' => trim($current_user->student_number),
                        'second_id' => trim($partner->student_number),
                    ]);
    
                    $this->container->flash->addMessage('success','Congrats! '.ucwords($partner->name).' is your new project partner');
                    return  $response->withRedirect($this->router->pathFor('student.index'));
                }

                else 
                {
                    $this->container->flash->addMessage('danger','You have already added '.ucwords($partner->name).' as your project partner');
                    return  $response->withRedirect($this->router->pathFor('student.index'));
                }

               
            }
                

        }

        else
        /**
         * select project partner student is offering a different programme
         */
         
        {
             //adding flash message
               $this->container->flash->addMessage('danger', ucwords($partner->name).' is  offering a different programme');
        
                return $response->withRedirect($this->router->pathFor('student.index'));
        }
        
       
    }



}