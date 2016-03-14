<?php

namespace Masterclass;


class Request
{
    protected $post;
    protected $get;
    protected $server;

    public function __construct($post, $get, $server)
    {
        $this->post = $post;
        $this->get = $get;
        $this->server = $server;
    }

    public function getQueryParams()
    {
        return $this->get;
    }

    public function getPostParams()
    {
        return $this->post;
    }

    public function getServerParams()
    {
        return $this->server;
    }

    public function getQueryParam($paramName)
    {
        return is_string($paramName) ? $this->get[$paramName] ?? null : null;
    }

    public function getPostParam($paramName)
    {
        return is_string($paramName) ? $this->post[$paramName] ?? null : null;
    }

    public function getServerParam($paramName)
    {
        return is_string($paramName) ? $this->server[$paramName] ?? null : null;
    }
}
