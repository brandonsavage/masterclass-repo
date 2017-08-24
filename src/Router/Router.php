<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/22/17
 * Time: 09:29
 */

namespace Masterclass\Router;


use Masterclass\Request;
use Masterclass\Router\Routes\RouteInterface;

class Router
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * Router constructor.
     * @param Request $request
     * @param array $routes
     */
    public function __construct(Request $request, array $routes = [])
    {
        $this->request = $request;

        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    public function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;
    }

    public function findMatch()
    {
        $path = parse_url($this->request->getServer('REQUEST_URI'), PHP_URL_PATH);

        /** @var RouteInterface $route */
        foreach ($this->routes as $route) {
            if ($route->matchRoute($path, $this->request->getServer('REQUEST_METHOD'))) {
                return $route;
            }
        }

        return false;
    }
}