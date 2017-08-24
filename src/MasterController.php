<?php

namespace Masterclass;

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
    
    public function __construct(Request $request, Router $router, array $config = []) {
        $this->request = $request;
        $this->router = $router;
        $this->config = $config;
    }
    
    public function execute() {
        $call = $this->_determineControllers();
        $class = $call['controller'];
        $method = $call['method'];
        $o = new $class($this->request, $this->generatePDO($this->config));
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

    protected function generatePDO(array $config)
    {
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ModelLocator::setPdo($db);
        return $db;
    }
}