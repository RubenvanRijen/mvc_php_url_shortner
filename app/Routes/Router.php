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
        $routeData = ['controller' => $controller, 'action' => $action];
        $routeParams = [];

        // Extract route parameters from the route string and replace them with regex capture groups
        $pattern = preg_replace_callback('/\{([^\}]+)\}/', function ($matches) use (&$routeParams) {
            $routeParams[] = $matches[1];
            return '([^/]+)';
        }, $route);

        $routeData['routeParams'] = $routeParams;
        $routeData['pattern'] = "~^$pattern$~";

        $this->routes[$route] = $routeData;
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

            $routeParams = $this->extractRouteParams($uri, $matchedRoute);
            $controllerInstance = new $controller();
            $controllerInstance->$action($routeParams);
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
            // Split the URI into path and query parts
            list($path, $query) = explode('?', $uri . '?', 2);

            if ($this->matchesRoute($path, $route)) {
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

    /**
     * get the paramas from the route
     * @param string $uri
     * @param string $route
     * @return array
     */
    private function extractRouteParams(string $uri, array $routeData): array
    {
        $routeParams = [];
        $pattern = $routeData['pattern'];
        $matches = [];
        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // Remove the first match (the full URI)
            $routeParams = array_combine($routeData['routeParams'], $matches);
        }

        return $routeParams;
    }
}