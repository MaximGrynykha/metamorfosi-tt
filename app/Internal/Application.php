<?php

namespace App\Internal;

use App\Internal\Controller;
use App\Internal\Config;
use App\Internal\Database;
use App\Internal\DbModel;
use App\Internal\Interface\Error;
use App\Internal\Interface\Exception;
use App\Internal\Request;
use App\Internal\Response;
use App\Internal\Router;
use App\Internal\Session;
use App\Models\User;

class Application
{
    public static string $ROOT_DIR;

    /**
     * @var Application
     */
    public static Application $app;

    /**
     * @var Router
     */
    public readonly Router $router;

    /**
     * @var Request
     */
    public readonly Request $request;
    
    /**
     * @var Response
     */
    public readonly Response $response;
    
    /**
     * @var Session
     */
    public readonly Session $session;

    /**
     * @var Database
     */
    public readonly Database $database;
    
    /**
     * @var Controller
     */
    public readonly Controller $controller;
    
    /**
     * @var array
     */
    public ?array $user;

    /**
     * @var View
     */
    public readonly View $view;

    /**
     * @var Config
     */
    public readonly Config $config;
    
    /**
     * @param string $root_path 
     * 
     * @return void 
     */
    public function __construct(string $root_path)
    {
        self::$ROOT_DIR = $root_path;
        self::$app = $this;
        
        $this->config = new Config;
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session;
        $this->router = new Router($this->request, $this->response);
        $this->view = new View;
        $this->database = new Database;

        if ($user_id = $this->session->get('user')) {
            $userModel = new User;
            $this->user = $userModel->getById($user_id); 
        } else {
            $this->user = null;
        }

        date_default_timezone_set($this->config->get('app.timezone'));
        setlocale(LC_ALL, $this->config->get('app.locale'));
    }

    /**
     * @param Controller $controller 
     * 
     * @return void 
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return void
    */
    public function run(): void
    {        
        try {
            echo $this->router->resolve();
        } catch (\Exception $exception) {
            $this->response->setStatusCode($exception->getCode());
            echo $this->view->renderView('pages/_error', compact('exception'));
        }
    }

    /**
     * @param array $user 
     * 
     * @return bool 
     */
    public function login(array $user): bool
    {
        $this->user = $user;

        $this->session->set('user', $this->user['id']);

        return true;
    }

    /** 
     * @return void
    */
    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    /**
     * @return bool
    */
    public static function isGuest(): bool
    {
        return ! app()->user;
    }
}