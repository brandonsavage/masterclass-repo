<?php

namespace Jsposato\Router\Route;

interface RouteInterface
{
    public function matchRoute($requestPath, $requestType);

    public function getRoutePath();

    public function getRouteClass();
}