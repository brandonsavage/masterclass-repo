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
     */
    public function __construct()
    {
        $this->setupConfig();
        $this->setupRoutes();
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
     * Setup the default config
     */
    private function setupConfig()
    {
        $this->config = require_once __BASE_DIR__.'config.php';
    }

    /**
     * Setup the default routes
     */
    private function setupRoutes()
    {
        $this->routes = require_once __BASE_DIR__.'routes.php';
    }
}
