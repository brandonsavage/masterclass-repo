<?php

namespace Masterclass;

use Aura\Di\Container;

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
        $call = $this->_determineControllers();

        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $method = array_shift($call_class);

        // container can instantiate class w/ required dependencies.
        $o = $this->container->newInstance($class);

        return $o->$method();
    }

    private function _determineControllers()
    {
        $path = $_SERVER['REQUEST_URI'];
        $return = array();

        foreach ($this->config['routes'] as $k => $v) {
            $matches = array();
            $pattern = '$' . $k . '$';
            if (preg_match($pattern, $path, $matches)) {
                $controller_details = $v;
                $controller_method = explode('/', $controller_details);
                $return = array('call' => $controller_method);
            }
        }

        return $return;
    }
}
