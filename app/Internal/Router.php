<?php

namespace App\Internal;

use App\Exceptions\Http\BadRequestException;
use App\Exceptions\Http\NotFoundException;

class Router
{
    protected readonly string $routesDirectory;
    protected readonly string $routeFiles;

    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $routes;

    /**
     * @param Request $request 
     * @param Response $response 
     * 
     * @return void 
     */
    public function __construct(
        protected readonly Request $request,
        protected readonly Response $response
    ) {
        $this->routesDirectory = path()->to('/routes');
        $this->routeFiles = path()->to('/routes/*.php');

        $routes = [];

        foreach (glob($this->routeFiles) as $file) {
            $routes = [...$routes, ...require $file];
        }
        
        foreach ($routes as $index => $route) {
            [$method, $uri] = explode('~', $index);
            [$method, $uri] = [trim($method, '"'), trim($uri, '"')];

            $this->{mb_strtolower($method)}($uri, $route);
        }
    }

    /**
     * @param string $uri 
     * @param $callback 
     * 
     * @return void 
     */
    public function get(string $uri, $callback): void
    {
        $this->routes[HTTPMethod::GET->name][$uri] = $callback;
    }

    /**
     * @param string $uri 
     * @param $callback 
     * 
     * @return void 
     */
    public function post(string $uri, $callback): void
    {
        $this->routes[HTTPMethod::POST->name][$uri] = $callback;
    }

    /**
     * @param string $uri 
     * @param $callback 
     * 
     * @return void 
     */
    public function put(string $uri, $callback): void
    {

        $this->routes[HTTPMethod::PUT->name][$uri] = $callback;
    }   

    /**
     * @param string $uri 
     * @param $callback 
     * 
     * @return void 
     */
    public function delete(string $uri, $callback): void
    {
        $this->routes[HTTPMethod::DELETE->name][$uri] = $callback;
    }

    /**
     *  @return mixed
    */
    public function resolve(): mixed
    {
        if (mb_strlen($this->request->getPath()) > 1 
            && mb_substr($this->request->getPath(), -1) === '/'
        ) {
            $this->response->redirect(mb_substr($this->request->getPath(), 0, -1), 301);
        }

        $method = $this->request->method();

        $routes = [];

        $request_uri_segments = explode('/', $this->request->getPath());
        
        foreach ($this->routes[$method->name] as $uri => $route) {
            $route_uri_segments = explode('/', $uri);

            if (count($request_uri_segments) === count($route_uri_segments)) {
                $routes[$uri] = $route_uri_segments;
            }
        }

        $path = '';

        foreach ($routes as $uri => $segments) {
            foreach ($request_uri_segments as $index => $segment) {
                if (isset($segments[$index]) && $segments[$index] === $segment) {
                    if ($segment) $path .= '/'.$segment;
                    continue;
                } 

                if ($segments[$index] !== $segment) {
                    preg_match('/{(.*?)}/', $segments[$index], $param);

                    if (isset($param[1])) {
                        $this->request->setParam($param[1], $segment);
                        $path .= '/'.$segments[$index];
                    }
                }
            }
        }

        if (isset($this->routes[$method->name][$this->request->getPath()])) {
            $path = $this->request->getPath();
        } 

        // dd(key($routes), $this->request->getPath());

        // if (isset($this->routes[$method->name][key($routes)])
        //     && ! isset($this->routes[$method->name][$this->request->getPath()])
        // ) {
        //     throw new BadRequestException(message: 'Bad request', code: 400);
        // }


        if (! $path && empty($routes)) {
            throw new BadRequestException(message: 'Bad request', code: 400);
        }
        
        $handler = $this->routes[$method->name][$path]['handler'] ?? false;
        $middlewares = $this->routes[$method->name][$path]['middlewares'] ?? false;

        if (! $handler) {
            throw new NotFoundException(message: 'Page not found', code: 404);
        }

        if (is_string($handler)) {
            return app()->view->renderView($handler);
        }

        if (is_array($handler)) {
            /** @var \App\Internal\Controller $controller  */
            $controller = new $handler[0];
            $controller->action = $handler[1];

            app()->setController($controller);

            if ($middlewares) {
                foreach ($middlewares as $middleware) {
                    (new $middleware)->execute($this->request);
                }
            }
        }

        return call_user_func([$controller, $handler[1]], $this->request, $this->response);
    }
}