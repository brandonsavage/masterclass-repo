<?php

namespace Jsposato\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;
use Jsposato\Router\Route\GetRoute;
use Jsposato\Router\Route\PostRoute;

class RouterConfig extends Config
{
    public function define(Container $di) {
        $config = $di->get('config');
        $routes = $config['routes'];

        $routeObj = [];

        foreach($routes as $path => $route) {
            if($route['type'] == 'POST') {
                $routeObj[] = new PostRoute($path, $route['class']);
            } else {
                $routeObj[] = new GetRoute($path, $route['class']);
            }
        }

        $di->params['Jsposato\Router\Router'] = [
            'serverVars' => $_SERVER,
            'routes' => $routeObj
        ];
    }
}