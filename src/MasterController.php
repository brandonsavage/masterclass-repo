<?php

namespace Masterclass;

use Aura\Di\Container;
use PDO;

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

        $dbconfig = $this->config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $pdo = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // need this:
//        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $method = array_shift($call_class);
//        $o = new $class($pdo);

        // container can instantiate class w/ required dependencies.
        $o = $this->container->newInstance($class);

        return $o->$method();
    }

    private function _determineControllers()
    {
        if (isset($_SERVER['REDIRECT_BASE'])) {
            $rb = $_SERVER['REDIRECT_BASE'];
        } else {
            $rb = '';
        }

        $ruri = $_SERVER['REQUEST_URI'];
        $path = str_replace($rb, '', $ruri);
        $return = array();

        foreach ($this->config['routes'] as $k => $v) {
            $matches = array();
            $pattern = '$' . $k . '$';
            if (preg_match($pattern, $path, $matches)) {
                $controller_details = $v;
                $path_string = array_shift($matches);
                $arguments = $matches;
                $controller_method = explode('/', $controller_details);
                $return = array('call' => $controller_method);
            }
        }

        return $return;
    }

    private function _setupConfig($config)
    {
        $this->config = $config;
    }
}
