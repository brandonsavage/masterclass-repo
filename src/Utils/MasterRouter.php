<?php

namespace Masterclass\Utils;

class MasterRouter
{

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $routes;

    /**
     * MasterRouter constructor.
     * @param array $config
     * @param array $routes
     */
    public function __construct(array $config = [], array $routes = [])
    {
        $this->setupConfig($config);
        $this->setupRoutes($routes);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $call = $this->determineControllers();
        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $method = array_shift($call_class);
        $o = new $class($this->config);
        return $o->$method();
    }

    /**
     * @return array
     */
    private function determineControllers()
    {
        if (isset($_SERVER['REDIRECT_BASE'])) {
            $rb = $_SERVER['REDIRECT_BASE'];
        } else {
            $rb = '';
        }

        $ruri = $_SERVER['REQUEST_URI'];
        $path = str_replace($rb, '', $ruri);
        $return = array();

        foreach ($this->routes as $k => $v) {
            $matches = array();
            $pattern = '$' . $k . '$';
            if (preg_match($pattern, $path, $matches)) {
                $controller_details = $v;
                $path_string = array_shift($matches);
                $arguments = $matches;
                $controller_method = explode(':', $controller_details);
                $return = array('call' => $controller_method);
            }
        }

        return $return;
    }

    /**
     * @param $config
     */
    private function setupConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param $routes
     */
    private function setupRoutes($routes)
    {
        $this->routes = $routes;
    }
}
