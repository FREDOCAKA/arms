<?php
namespace  App\Helpers;

use App\Models\Project\Project;
use App\Models\Project\Category;
use App\Models\Project\Course;
use Illuminate\Database\Capsule\Manager as Capsule;

class Helper 
{

    /**
     * Returning all cateory
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function allCategory ($request,$response,$category)
    {
        $category  = Category::all();
        return $category;

    }
    /**
     * Return all projects
     *
     * @param [array] $request
     * @param [arrat] $response
     * @return void
     */
    public function projectCategory($request,$response)
    {
        $projects = Capsule::table('category')->join('projects','projects.category_id','=','category.id')->get();

         return $projects;
    }
    
    public function allCourses()
    {
        return Course::all();
    }

  
}