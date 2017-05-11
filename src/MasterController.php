<?php

namespace Masterclass;

use Aura\Di\Container;
use FastRoute\Dispatcher;

class MasterController
{
    protected $config;
    protected $container;
    protected $destination;

    public function __construct(Container $container, $config, RouteDestination $destination)
    {
        $this->container = $container;
        $this->config = $config;
        $this->destination = $destination;
    }

    public function execute()
    {
        $controller = $this->container->newInstance($this->destination->getClass());
        $method = $this->destination->getMethod();
        $args = $this->destination->getArgs();

        return $controller->$method($args);
    }
}
