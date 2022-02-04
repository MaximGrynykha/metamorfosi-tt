<?php

namespace App\Http\Controllers;

use App\Exceptions\Http\InvalidStatusCodeException;
use App\Internal\Controller;
use App\Internal\Request;
use App\Internal\Response;
use App\Models\User;

//AuthenticatedSessionController
class AuthController extends Controller
{
    public string $layout = 'auth';

    /** 
     * @return string
    */
    public function index(): string
    {
        return $this->render('pages/login');
    }

    /**
     * @param Request $request 
     * @param Response $response 
     * 
     * @return mixed 
     */
    public function store(Request $request, Response $response)
    {
        $userModel = new User;

        $user = $userModel->getByName($request->getBody()['name']);

        if (! $user) {
            // todo
            
            return false;
        }
        
        if (! password_verify($request->getBody()['password'], $user['password'])) {
            // todo
            
            return false;
        }
        
        app()->login($user);
        $response->redirect('/');
    }

    /**
     * @param Request $request 
     * @param Response $response 
     * 
     * @return void 
     * 
     * @throws InvalidStatusCodeException 
     */
    public function destroy(Request $request, Response $response): void
    {
        app()->logout();
        $response->redirect('/');
    }
}