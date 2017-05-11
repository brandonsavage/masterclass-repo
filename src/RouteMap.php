<?php
/**
 * @author Adam Altman <adam@rebilly.com>
 * masterclass-repo
 */

namespace Masterclass;


use FastRoute\Dispatcher;

class RouteMap
{
    protected $dispatcher;
    protected $request;

    public function __construct(Dispatcher $dispatcher, Request $request)
    {
        $this->dispatcher = $dispatcher;
        $this->request = $request;
    }

    /**
     * @return RouteDestination
     */
    public function handle()
    {

        $httpMethod = $this->request->getServerParam('REQUEST_METHOD');
        $uri = rawurldecode(parse_url($this->request->getServerParam('REQUEST_URI'), PHP_URL_PATH));

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                header("HTTP/1.1 404 Not Found");
                exit;
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                header("HTTP/1.1 405 Method Not Allowed");
                header($allowedMethods);
                exit;
                break;
            case Dispatcher::FOUND:
                $handler = explode(':', $routeInfo[1]);
                $vars = $routeInfo[2];
                // ... call $handler with $vars
                $class = $handler[0];
                $method = $handler[1];
                return new RouteDestination($class, $method, $vars);
                break;
        }

    }
}
