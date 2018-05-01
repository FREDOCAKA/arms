<?php

namespace App\Controllers\Project;

use Slim\Http\UploadFile;
use App\Models\Project\Project;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;

use App\Models\Project\Category;
class ProjectController extends Controller

{

    /**
     * New Uploaded File
     *
     * @var [string]
     */
    protected $newFile;

    /**
     * List all the available projects
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function index($request,$response,$args)
    {


        $args = $this->db->table('category')->join('projects','category.id','=','projects.category_id')
                                            ->paginate(10,['*'],'page',$request->getParam('page'));

                                         
      
        return $this->view->render($response,'project/project.twig',
        ['items' => $args ]
    );
    }

    /**
     * Get create project page
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function create($request,$response, array $args)
    {

      return $this->view->render($response,'project/create.twig');
    }

    /**
     * Post new project
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function postProject($request,$response)
    {
        /**
         * Validation
         */
        $validator = $this->validator->validate($request,[
            'title'     => v::notEmpty(),
            'category'  => v::notEmpty(),
            'body'      => v::notEmpty(),
            
        ]);

        //Validation failed
        if($validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('project.create'));
        }
    
         /***
          * Uploading file
          */

          $this->container->MyFiles->uploadFiles($request,$_SERVER['DOCUMENT_ROOT'].
                                    $this->router->pathFor('home').'/storage/docs/','file');

          $filename = $this->container->MyFiles->fileName;

          /**
           * Create project
           */
            Project::create ([
                'title'         => $request->getParam('title'),
                'category_id'   => $request->getParam('category'),
                'body'          => $request->getParam('body'),
                'uploads'       => $filename,
            ]);

        //flashing messages
        $this->flash->addMessage('success','You have successfully created a new project');

        return $response->withRedirect($this->router->pathFor('project.index'));

    }

    /**
     * Delete a project
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return void
     */
    public function deleteProject($request,$response,$args)
    {


        $project = Project::find($args['id']);

        //obtaining file path

        $file = $_SERVER['DOCUMENT_ROOT'].$this->router->pathFor('home').'storage/docs/'.$project->uploads;
    

        $file ? unlink($file) : ' ';


        //deleting project
        $project->delete();

        $this->flash->addMessage('danger','You have successfully delete the project');

        return $response->withRedirect($this->router->pathFor('project.index'));

    }

    /**
     * Display project in a single page
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function showProject($request,$response,$args)
    {
        $project  = Project::find($args['id']);
        return $this->view->render($response,'project/single.twig',
        ['project' => $project]);
    }

    /**
     * GET update view
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return View
     */
    public function getUpdate($request,$response,$args)
    {
        $project = Project::find($args['id']);
        $category = Category::find($project->category_id);
        return $this->view->render($response,'project/update.twig',
                                 [ 'project'  => $project,
                                   'category' => $category]);
    }

    /**
     * Updating a project
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function updateProject($request,$response,$args)
    {

        //handling validation
        $validator = $this->validator->validate($request,[
            'title'    => v::notEmpty(),
            'category' => v::notEmpty(),
            'body'     => v::notEmpty()
        ]);

        //retrieving the project
        $project = Project::find($args['id']);

        /**
         * Handling file uploads
         */
        if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
        {

            //full path
            $full_path = $_SERVER['DOCUMENT_ROOT'].$this->router->pathFor('home').'storage/docs/';

            //removing the old file
            $oldFile = $full_path.$project->uploads;
            $oldFile ? unlink($oldFile) : ' ';

            //uploading the new file
            $this->MyFiles->uploadFiles($request,$full_path,'file');

            //Retrieving filename
            $this->newFile = $this->MyFiles->fileName;
        
        }
        else
        {
            $this->newFile  =  $project->uploads;

        }
       
        //updating  project
        $project->update([
            'title'     => $request->getParam('title'),
            'category'  => $request->getParam('category'),
            'body'      => $request->getParam('body'),
            'uploads'   => $request->getParam('file'),
        ]);

        //flash mesages
        $this->flash->addMessage('success','Update successfull');
        
        //redirect
        return $response->withRedirect($this->router->pathFor('project.index'));

    }

    /**
     * File download
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function fileDownload($request,$response,$args)
    {
        
        $id  = Project::find($args['id']);

       $download = $this->MyFiles->downloadFile($response,$this->router->pathFor('home'),$id->uploads);

       return $download;
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
                                            

       return $this->view->render($response,'project/index.twig',[
           'items' => $query
       ]);
    }
    
}