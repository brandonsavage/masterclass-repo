<?php

namespace Masterclass\Router\Route;

class PostRoute extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'POST') {
            return false;
        }

        if ($this->routePath != $requestPath) {
            return false;
        }

        return true;
    }
}
