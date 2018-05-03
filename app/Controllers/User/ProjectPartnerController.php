<?php

namespace App\Controllers\User;

use App\Models\Student;
use App\Controllers\Controller;
use App\Models\Project\ProjectPartner;
use Illuminate\Database\QueryException as Exception;

class ProjectPartnerController extends Controller

{

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
            // $db = ProjectPartner::all();


            // var_dump($db);

            // die();


        
                ProjectPartner::create([
                    'first_id' => $current_user->id,
                    'second_id' => $partner->id,
                ]);

                $this->container->flash->addMessage('success','Congrats! '.ucwords($partner->name).' is your new project partner');
           
                
           

            
            return $response->withRedirect($this->router->pathFor('student.index'));

        }
        
        //adding flash message
        $this->container->flash->addMessage('danger', ucwords($partner->name).' is  offering a different programme');

        return $response->withRedirect($this->router->pathFor('student.index'));
    }


}