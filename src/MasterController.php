<?php

namespace Jsposato;


use Aura\Di\Container;
use Jsposato\Router\Router;
//use PDO;

class MasterController {

    /**
     * @var array
     */
    private $config;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Router
     */
    protected $router;


    public function __construct(Container $container, array $config = [], Router $router) {
        $this->container = $container;
        $this->config = $config;
        $this->router = $router;
    }


    public function execute() {
//        $call = $this->_determineControllers();
//        $call_class = $call['call'];
//        $class = ucfirst(array_shift($call_class));
//        $method = array_shift($call_class);
        $match = $this->_determineControllers();

        $calling = $match->getRouteClass();
        list($class, $method) = explode(':', $calling);

        $o = $this->container->newInstance($class);
        return $o->$method();
    }
    
    protected function _determineControllers()
    {

        $router = $this->router;
        $match = $router->findMatch();

        if(!$match) {
            throw new \Exception('No route match found');
        }
        return $match;
    }
}