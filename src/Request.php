<?php

namespace Masterclass;

class Request
{
    /**
     * @var array
     */
    protected $globals = [];

    /**
     * @var array
     */
    protected $get = [];

    /**
     * @var array
     */
    protected $post = [];

    /**
     * @var array
     */
    protected $server = [];

    /**
     * Request constructor.
     * @param array $globals
     */
    public function __construct(array $globals = [])
    {
        $this->globals = $globals;
        $this->processGlobals($globals);
    }

    /**
     * @param array $globals
     */
    protected function processGlobals(array $globals = [])
    {
        $this->get = $globals['_GET'];
        $this->post = $globals['_POST'];
        $this->server = $globals['_SERVER'];
    }

    public function getQuery($key, $default = null)
    {
        if (isset($this->get[$key])) {
            return $this->get[$key];
        }

        return $default;
    }

    public function getPost($key, $default = null)
    {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        }

        return $default;
    }

    public function getServer($key, $default = null)
    {
        if (isset($this->server[$key])) {
            return $this->server[$key];
        }

        return $default;
    }
}