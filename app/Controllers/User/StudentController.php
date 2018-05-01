<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

use App\Models\Student;

class StudentController extends Controller 

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
        $args = $this->db->table('courses')->rightJoin('students','courses.id','=','students.course_id')
                              ->paginate(0,['*'],'page',$request->getParam('page'));


        return $this->view->render($response,'admin/student/index.twig',[
            'items' => $args,
            'list' =>  $list
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
        $student  = Student::find($args['id']);

        return $this->view->render($response,'admin/student/show.twig',[
            'student' => $student
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
        $del = Student::find($args['id']);

        $del->delete();
        $this->flash->addMessage('danger','You have successfully deleted the student');

        return $response->withRedirect($this->router->pathFor('student.index'));

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
        $reg_no = $request->getParam('registration_number');
        $course = $request->getParam('course');

       $query = $this->db->table('students')->join('courses','courses.id','=','students.course_id')
                                            ->where('name', 'like',"%$name%")
                                            ->where('registration_number','like',"%$reg_no%")
                                            ->where('course_id','like',"%$course%")
                                            ->limit(13)->get();
                                            // paginate(5,['*'],'page',$request->getParam('page'));

       return $this->view->render($response,'admin/student/index.twig',[
           'items' => $query
       ]);
    }

}