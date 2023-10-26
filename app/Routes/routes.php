<?php

use MvcPhpUrlShortner\Controllers\UrlController;
use MvcPhpUrlShortner\Routes\Router;

// create the logic for the routes
$router = new Router();

// Create the instances of the controllers with the required dependencies if needed. But not smart to do for now.
$urlController = new UrlController();

// create the routes
$router->addRoute('/urls', $urlController, 'index');
$router->addRoute('/', $urlController, 'index');
$router->addRoute('/urls/create', $urlController, 'createShortUrl');
$router->addRoute('/short/{short_url}', $urlController, 'redirectToOriginalUrl');


// get the url asked
$uri = $_SERVER['REQUEST_URI'];

// serve the uri or throw an exception for now.
try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    throw $e;
}