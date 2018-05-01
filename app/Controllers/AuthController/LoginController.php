<?php
namespace App\Controllers\AuthController;

use App\Models\Student;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class LoginController extends Controller

{

    /**
     * Render login view
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function getLogin($request,$response)
    {
        return $this->view->render($response,'auth/login.twig');
    }

    /**
     * Post Login form
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function postLogin($request,$response)
    {
        //Validation
        $validate = $this->validator->validate($request,[
            'email'    => v::notEmpty()->email(),
            'password' => v::notEmpty()
        ]);

        if($validate->failed())
        {
            return $response->withRedirect($this->router->pathFor('auth.login'));
        }
        
        //attempting authentication
         $auth = $this->auth->attempt(
                 $request->getParam('email'),
                 $request->getParam('password'));
       
      
        if($auth && isset($_SESSION['approve'])){

            unset($_SESSION['user']);
            unset($_SESSION['role']);
            unset($_SESSION['approve']);

            $this->container->flash->addMessage('danger','Sorry, your  account has not been approved.');
            return $response->withRedirect($this->router->pathFor('auth.login'));
        }

        elseif ($auth && !isset($_SESSION['approve']))
        {
            return $response->withRedirect($this->router->pathFor('dashboard'));
        }

      
 
        $this->container->flash->addMessage('danger','Password and Email do not match');
        return $response->withRedirect($this->router->pathFor('auth.login'));
        
        
    }
    /**
     * User logout
     *
     * @param [array] $request
     * @param [array] $response
     * @return void
     */
    public function getLogout($request,$response)
    {
        $this->auth->logout();

        return $response->withRedirect($this->router->pathFor('auth.login'));

    }

}