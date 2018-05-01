<?php

namespace App\Controllers\Project;

use App\Models\Project\Course;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class CourseController extends Controller

{

    
    /**
     * This method returns all courses
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return courses
     */
    public function index($request,$response,$args)
    {
        $courses = Course::paginate(10,['*'],'page',$request->getParam('page'));
    
        return $this->view->render($response,'course/index.twig',[
            'items' => $courses,
        ]);

    }

    /**
     * Get course create view
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function show($request,$response)
    {
        return $this->view->render($response,'course/create.twig');

    }

    /**
     * Create a new course
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function create($request,$response)
    {
        //validation
        $validator  = $this->validator->validate($request,
                                     [ 'course_name' => v::courseAvailable()->notEmpty()]);

        if($validator->failed()){
            return $response->withRedirect($this->router->pathFor('course.create'));
        }

        //create a new course

        Course::create(['course_name' => strtolower($request->getParam('course_name')) ]);

        //flash message
        $this->flash->addMessage('success','A new course has been successfully created');

        //redirect
        return $response->withRedirect($this->router->pathFor('course.index'));

    }
    /**
     * Get update course view
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return void
     */
    public function getUpdate($request,$response,$args)
    {
        $course = Course::find($args['id']);

        return $this->view->render($response,'course/update.twig',[
            'course' => $course,
        ]);

        
    }
    /**
     * Update course
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return void
     */
    public function update($request,$response,$args)
    {
    
         //validation
         $validator  = $this->validator->validate($request,
         [ 'course_name' => v::courseAvailable()->notEmpty()]);

        if($validator->failed()){
        return $response->withRedirect($this->router->pathFor('course.update',[ 'id' => $args['id']]));
        }

        //update the category
        $course = Course::find($args['id']);

        $course->update([
            'course_name' => strtolower($request->getParam('course_name'))
        ]);

        $this->flash->addMessage('success','Update successfull');

        return $response->withRedirect($this->router->pathFor('course.index'));


    }

    /**
     * Delete course method
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return void
     */
    public function delete($request,$response,$args)
    {
        $course = Course::find($args['id']);

        $course->delete();

        $this->flash->addMessage('danger','The course has been successfully deleted');
        
     return $response->withRedirect($this->router->pathFor('course.index'));
        
        

    }

}