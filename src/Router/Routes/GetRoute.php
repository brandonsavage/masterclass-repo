<?php

namespace Masterclass\Router\Routes;

class GetRoute extends AbstractRoute
{

    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'GET') {
            return false;
        }

        if ($requestPath != $this->routePath) {
            return false;
        }

        return true;
    }
}