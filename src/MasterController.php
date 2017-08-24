<?php

namespace Masterclass;

use Aura\Di\Container;
use Masterclass\Router\Router;
use PDO;

class MasterController {

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var Container
     */
    protected $container;

    public function __construct(Request $request, Router $router, Container $container) {
        $this->request = $request;
        $this->router = $router;
        $this->container = $container;
    }
    
    public function execute() {
        $call = $this->_determineControllers();
        $class = $call['controller'];
        $method = $call['method'];
        $o = $this->container->newInstance($class);
        return $o->$method();
    }
    
    private function _determineControllers()
    {
        $route = $this->router->findMatch();

        if ($route) {
            $info = $route->getRouteInfo();


            $details = explode('@', $info['info']);
            return ['controller' => $details[0], 'method' => $details[1]];
        }

        return [];
    }
}