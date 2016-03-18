<?php
namespace Masterclass\FrontController;

use Aura\Di\Container as Di_Container;
use Masterclass\Router\Router;

class MasterController
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var Di_Container
     */
    protected $container;

    /**
     * @var Router
     */
    protected $router;

    public function __construct(Di_Container $container, $config, Router $router)
    {
        $this->config = $config;
        $this->container = $container;
        $this->router = $router;
    }

    public function execute()
    {
        $match = $this->_determineControllers();

        $calling = $match->getRouteClass();
        list($class, $method) = explode(':', $calling);
        $controller_object = $this->container->newInstance($class);
        return $controller_object->$method();
    }

    private function _determineControllers()
    {
        $router = $this->router;
        $match = $router->findMatch();

        if (!$match) {
            throw new \Exception('No route match found');
        }
        return $match;
    }

}
