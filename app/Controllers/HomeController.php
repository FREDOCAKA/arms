<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Project\ProjectPartner;
class HomeController extends Controller

{
    protected $leader;

    public function index($request,$response)
    {
        return $this->view->render($response,'home.twig');
    }


    /**
     * This method returns the current user dashboard
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return void
     */
    public function getDashboard($request,$response,$args)
    {


        //Check if the login student has a project partner
        $available =  ProjectPartner::where('first_id',$this->auth->user()->student_number)
                         ->orWhere('second_id',$this->auth->user()->student_number)->get();
       

        //select current login student
        $first_id = ProjectPartner::where('first_id',$this->auth->user()->student_number)->count();
       

        //check project leader
        if($first_id > 0)
        {
        
            $partners = $this->db->table('students')->join('project_partner','student_number',
                       '=','second_id')
                        ->where('first_id','=',$this->auth->user()->student_number)->get();

            $this->leader = $partners;

            // die();
        }

        else
        {
            /**
             * The current student is not a project leader, 
             * Thus obtain the project leader
             * 
             */

             
            $this->leader   = $this->db->table('students')->join('project_partner','student_number',
                        '=','first_id')
                        ->where('second_id','=',$this->auth->user()->student_number)->get();
            
            
            /**
             * check if the current user is the project partner
             */
            
            if($this->leader)

            {
                /**
                 * Select all project partners associate to the project leader
                 */
                $partners  = $this->db->table('students')->join('project_partner','student_number',
                '=','second_id')
                 ->where('first_id','=',$this->leader[0]->student_number)->get(); 
            }

            else 

            {
                $partners = "";

            }

            
        }        
        return $this->view->render($response,'dashboard/dashboard.twig',[
            'partners' => $partners,
            'leader'  => $this->leader[0],
            'available' => $available
        ]);
    }
    
   

}


