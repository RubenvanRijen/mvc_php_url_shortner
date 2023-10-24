<?php

namespace MvcPhpUrlShortner\Routes;

use Exception;

class Router
{
    protected array $routes = [];

    /**
     * @param $route
     * @param $controller
     * @param $action
     * @return void
     */
    public function addRoute($route, $controller, $action): void
    {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }


    /**
     * @param $uri
     * @return void
     * @throws Exception
     */
    public function dispatch($uri): void
    {
        if (array_key_exists($uri, $this->routes)) {
            $controller = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } else {
            throw new Exception("No route found for URI: $uri");
        }
    }
}