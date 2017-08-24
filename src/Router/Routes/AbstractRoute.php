<?php

namespace Masterclass\Router\Routes;

abstract class AbstractRoute implements RouteInterface
{
    /** @var  string */
    protected $routePath;

    /** @var  mixed */
    protected $routeInfo;

    public function __construct($routePath, $routeInfo)
    {
        $this->routePath = $routePath;
        $this->routeInfo = $routeInfo;
    }

    public function getRouteInfo()
    {
        return $this->routeInfo;
    }

    public function getRoutePath()
    {
        return $this->routePath;
    }
}