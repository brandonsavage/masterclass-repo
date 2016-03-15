<?php

namespace Masterclass;


class RouteDestination
{

    protected $class;
    protected $method;
    protected $args;

    public function __construct(array $routeInfo)
    {
        extract($routeInfo);
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getArgs()
    {
        return $this->args;
    }
}
