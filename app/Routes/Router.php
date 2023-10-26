<?php

namespace MvcPhpUrlShortner\Routes;

use Exception;
use MvcPhpUrlShortner\Controllers\BaseController;

class Router
{
    protected array $routes = [];

    /**
     * Add a route to the router with optional route parameters.
     *
     * @param string $route
     * @param BaseController $controller
     * @param string $action
     */
    public function addRoute(string $route, BaseController $controller, string $action): void
    {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    /**
     * Dispatch the request to the appropriate controller action.
     *
     * @param string $uri
     * @return void
     * @throws Exception
     */
    public function dispatch(string $uri): void
    {
        $matchedRoute = $this->findMatchingRoute($uri);

        if ($matchedRoute) {
            $controller = $matchedRoute['controller'];
            $action = $matchedRoute['action'];

            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            throw new Exception("No route found for URI: $uri");
        }
    }

    /**
     * Find a matching route based on the given URI.
     *
     * @param string $uri
     * @return array|null
     */
    private function findMatchingRoute(string $uri): ?array
    {
        foreach ($this->routes as $route => $routeInfo) {
            if ($this->matchesRoute($uri, $route)) {
                return $routeInfo;
            }
        }

        return null;
    }

    /**
     * Check if the given URI matches a route with optional parameters.
     *
     * @param string $uri
     * @param string $route
     * @return bool
     */
    private function matchesRoute($uri, $route): bool
    {
        $uriParts = explode('/', ltrim($uri, '/'));
        $routeParts = explode('/', ltrim($route, '/'));

        if (count($uriParts) !== count($routeParts)) {
            return false;
        }

        for ($i = 0; $i < count($routeParts); $i++) {
            if ($routeParts[$i] !== $uriParts[$i] && strpos($routeParts[$i], '{') === false) {
                return false;
            }
        }

        return true;
    }
}