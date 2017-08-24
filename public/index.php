<?php

session_start();

$config = require_once('../config.php');
require '../vendor/autoload.php';

$request = new \Masterclass\Request($GLOBALS);

$routes = [];

foreach ($config['routes'] as $path => $route) {
    if ($route['method'] == 'GET') {
        $route = new \Masterclass\Router\Routes\GetRoute($path, $route);
    } else {
        $route = new \Masterclass\Router\Routes\PostRoute($path, $route);
    }

    $routes[] = $route;
}

$router = new \Masterclass\Router\Router($request, $routes);

$framework = new Masterclass\MasterController($request, $router, $config);
echo $framework->execute();