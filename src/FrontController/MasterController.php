<?php
namespace Masterclass\FrontController;

use Aura\Di\Container as Di_Container;
use Masterclass\Router\Router;
use Aura\Web\Response as Web_Response;

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
        $response = $controller_object->$method();
        if ($response instanceof Web_Response) {
            $this->sendResponse($response);
        }
    }

    public function sendResponse(Web_Response $response)
    {
        header($response->status->get(), true, $response->status->getCode());

        // send non-cookie headers
        foreach($response->headers->get() as $label => $value) {
            header("{$label}: {$value}");
        }

        //send cookies
        foreach ($response->cookies->get() as $name => $cookie) {
            setcookie(
                $name,
                $cookie['value'],
                $cookie['expire'],
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }
        header('Connection: close');

        // send content
        echo $response->content->get();
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
