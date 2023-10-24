<?php

namespace MvcPhpUrlShortner\Routes;


use MvcPhpUrlShortner\Controllers\UrlController;

$router = new Router();

$router->addRoute('/', UrlController::class, 'index');


$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);