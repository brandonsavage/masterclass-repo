<?php

namespace Masterclass;

use Aura\Di\Container;
use FastRoute\Dispatcher;

class MasterController
{
    private $config;

    protected $container;

    public function __construct(Container $container, $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    public function execute()
    {
        $routeMap = $this->container->newInstance(RouteMap::class);
        $dispatchDetail = $routeMap->handle();

        $controller = $this->container->newInstance($dispatchDetail['class']);
        $method = $dispatchDetail['method'];
        $vars = $dispatchDetail['vars'];

        return $controller->$method($vars);
    }
}
