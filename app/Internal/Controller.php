<?php

namespace App\Internal;

abstract class Controller
{
    public string $layout = 'main';
    public string $action = '';

    /**
     * @var App\Middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    /**
     * @return array
    */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param string $view 
     * @param array $params
     *  
     * @return string 
     */
    protected function render(string $view, array $params = []): string
    {
        return app()->view->renderView($view, $params);
    }

    /**
     * @param string $layout 
     * 
     * @return void 
     */
    protected function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @param Middleware $middleware 
     * 
     * @return void 
     */
    protected function registerMiddleware(Middleware $middleware): void
    {   
        $this->middlewares[] = $middleware;
    }
}