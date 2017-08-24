<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/22/17
 * Time: 20:41
 */

namespace Masterclass;


class Container
{
    /**
     * @var array
     */
    protected $services = [];

    /**
     * @param $service
     * @param callable $callable
     */
    public function set($service, callable $callable)
    {
        $this->services[$service] = $callable;
    }

    public function get($service)
    {
        if (isset($this->services[$service])) {
            return $this->services[$service]();
        }

        throw new \InvalidArgumentException($service . ' is not registered');
    }
}