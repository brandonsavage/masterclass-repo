<?php

namespace Jsposato\Router\Route;

abstract class AbstractRoute implements RouteInterface
{
    protected $routePath;

    protected $routeClass;

    public function __construct($routePath, $routeClass) {
        $this->routeClass = $routeClass;
        $this->routePath = $routePath;
    }

    public function getRoutePath() {
        return $this->routePath;
    }

    public function getRouteClass() {
        return $this->routeClass;
    }

    abstract public function matchRoute($requestPath, $requestType);
}