<?php

namespace Masterclass;


class Request
{
    protected $post;
    protected $get;

    public function __construct($post, $get)
    {
        $this->post = $post;
        $this->get = $get;
    }

    public function getQueryParams()
    {
        return $this->get;
    }

    public function getPostParams()
    {
        return $this->post;
    }

    public function getQueryParam($paramName)
    {
        return $this->get[$paramName] ?? null;
    }

    public function getPostParam($paramName)
    {
        return $this->post[$paramName] ?? null;
    }
}
