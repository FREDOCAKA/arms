<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

use App\Models\Lecturer;

class LecturerController extends Controller 

{

    /**
     * Return all students
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $args = Lecturer::paginate(15,['*'],'page',$request->getParam('page'));


        return $this->view->render($response,'admin/lecturer/index.twig',[
            'items' => $args,
        ]);
    }

    /**
     * Display a student
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function show($request,$response,$args)
    {
        $lecturer  = Lecturer::find($args['id']);

        return $this->view->render($response,'admin/lecturer/show.twig',[
            'lecturer' => $lecturer
        ]);

    }
    
    /**
     * Delete student
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function delete($request,$response,$args)
    {
        $del = Lecturer::find($args['id']);

        $del->delete();
        $this->flash->addMessage('danger','You have successfully deleted  '.ucwords($del->name).'');

        return $response->withRedirect($this->router->pathFor('lecturer.index'));

    }

    public function approve($request,$response,$args)

    {
        $lecturer = Lecturer::find($args['id']);

        $lecturer->update([
            'status' => '1'
        ]);

        $this->flash->addMessage('success','You have successfully aproved '. ucwords($lecturer->name).'');
        
        return $response->withRedirect($this->router->pathFor('lecturer.index'));

    }


    /**
     * Search method
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function search($request, $response, $args)
    {
        $name   = $request->getParam('name');
        $email  = $request->getParam('email');
        $status = $request->getParam('status');
       

       $query = $this->db->table('lecturers')->where('name', 'like',"%$name%")
                                            ->where('email','like',"%$email%")
                                            ->where('status','like',"%$status%")
                                            ->limit(15)->get();
                                            

       return $this->view->render($response,'admin/lecturer/index.twig',[
           'items' => $query
       ]);
    }

}