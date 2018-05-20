<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\Project\Project;
use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use App\Models\Project\Category;
use App\Models\Project\ProjectPartner;
class HomeController extends Controller

{

    /**
     * Retrieve all projects
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function index($request,$response,$args)
    {

        $args = Category::leftJoin('projects','category.id','=','projects.category_id')
                            ->paginate(10,['*'],'page',$request->getParam('page'));

            

        return $this->view->render($response,'home.twig',[
            'items' => $args
        ]);
    }

    /**
     * This method project details
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function show($request,$response,$args)
    {
        $project = Project::find($args['id']);

        
        return $this->view->render($response,'show.twig',[
            'project' => $project
        ]);
    }



}


