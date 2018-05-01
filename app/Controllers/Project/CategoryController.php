<?php
namespace App\Controllers\Project;

use App\Controllers\Controller;
use App\Models\Project\Category;
use Respect\Validation\Validator as v;


class CategoryController extends Controller
{


    /**
     * This method returns category index view
     *
     * @param [array] $request
     * @param [array] $response
     * @param [array] $args
     * @return void
     */
    public function index($request,$response,$args)
    {
        $category = Category::paginate(10,['*'],'page', $request->getParam('page'));
        return $this->view->render($response,'category/index.twig',[
            'items' => $category,
        ]);
        
    }

        /**
     * Delete a category
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void
     */
    public function deleteCategory($request,$response,$args)
    {
      
        $del = Category::find($args['id']);

        $del->delete();

        $this->flash->addMessage('danger','Category has been deleted');

        return $response->withRedirect($this->router->pathFor('category.index'));

    }

    /**
     * This method returns create view for project category
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function show($request,$response)
    {
        return $this->view->render($response,'category/create.twig');

    }

    /**
     * Creating a new category
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function create($request,$response)
    {

        //Handling validation
        $validator = $this->validator->validate($request,[
            'name' => v::notEmpty()->categoryAvailable(),
        ]);

        if($validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('category.create'));
        }
     

        //creating a new category
        Category::create([
            'name' => $request->getParam('name')
        ]);

        $this->flash->addMessage('success','A new category has been successfully created');

        return $response->withRedirect($this->router->pathFor('category.index'));
    }

    /**
     * Get upadte view
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return view
     */
    public function getUpdate($request,$response,$args)
    {
    
        $category = Category::find($args['id']);
       
        return $this->view->render($response,'category/update.twig',[
            'category' => $category
        ]);
    }
    
    /**
     * This method updates category
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function update($request,$response,$args)
    {
       
        //validation

        $validator = $this->validator->validate($request,[
            'name' => v::notEmpty()->categoryAvailable(),
        ]);

        //failed validation
        if($validator->failed()){
            return $response->withRedirect($this->router->pathFor('category.update',
            ['id' => $args['id']]));

        }
        //updating category

        $category = Category::find($args['id']);
        $category->update([
            'name' =>$request->getParam('name')
        ]);
        
        $this->flash->addMessage('success','Update successfull');

        return $response->withRedirect($this->router->pathFor('category.index'));


    }



}