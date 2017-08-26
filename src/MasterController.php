<?php

namespace Masterclass;

use Aura\Di\Container;
use Aura\Web\Response;
use Masterclass\Responder\ResponseManager;
use Masterclass\Router\Router;
use PDO;

class MasterController {

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

    /**
     * @var ResponseManager
     */
    protected $responseManager;

    public function __construct(
        Router $router,
        ResponseManager $responseManager,
        Container $container
    ) {
        $this->router = $router;
        $this->responseManager = $responseManager;
        $this->container = $container;
    }

    public function execute() {
        $call = $this->_determineControllers();
        if (is_array($call['info'])) {
            $this->executeADR($call['info']);
        } else {
            return $this->executeMVC($call['info']);
        }
    }

    public function executeMVC($call)
    {
        list($class, $method) = explode('@', $call);
        $object = $this->container->newInstance($class);
        return $object->$method();
    }

    public function executeADR($call)
    {
        $responder = $call['responder'];

        if (isset($call['action'])) {
            list($action, $method) = explode('@', $call['action']);
            $object = $this->container->newInstance($action);
            $result = $object->$method();
        } else {
            $result =[];
        }

        $responder = $this->container->newInstance($responder);
        return $this->responseManager->execute($responder, $result);

    }

    private function _determineControllers()
    {
        $route = $this->router->findMatch();

        if (!$route) {
            throw new \Exception('No route match found!');
        }

        return $route->getRouteInfo();
    }
}