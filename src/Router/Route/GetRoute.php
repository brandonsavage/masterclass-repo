<?php

namespace Masterclass\Router\Route;

class GetRoute extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'GET') {
            return false;
        }

        if ($this->routePath != $requestPath) {
            return false;
        }

        return true;
    }
}
