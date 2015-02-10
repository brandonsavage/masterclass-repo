<?php

namespace Jsposato\Router;

use Jsposato\Router\Route\RouteInterface;

class Router
{
    /**
     * @var array
     */
    protected $serverVars;

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @param array $serverVars
     * @param array $routes
     */
    public function __construct(array $serverVars, array $routes = []) {
        $this->serverVars = $serverVars;

        foreach($routes as $route) {
            $this->addRoute($route);
        }
    }

    /**
     * addRoute
     *
     * add a route to the array
     *
     * @param RouteInterface $route
     *
     * @author  jsposato
     * @version 1.0
     */
    public function addRoute(RouteInterface $route) {
        $this->routes[] = $route;
    }

    /**
     * findMatch
     *
     * match request route to routes in config
     *
     * @return bool
     *
     * @author  jsposato
     * @version 1.0
     */
    public function findMatch() {
        $path = parse_url($this->serverVars['REQUEST_URI'], PHP_URL_PATH);

        foreach($this->routes as $route) {
            if($route->matchRoute($path, $this->serverVars['REQUEST_METHOD'])) {
                return $route;
            }
        }

        // no match so return false
        return false;
    }
}