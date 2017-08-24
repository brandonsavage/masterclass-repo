<?php

namespace Masterclass\Router\Routes;

class PostRoute extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'POST') {
            return false;
        }

        if ($requestPath != $this->routePath) {
            return false;
        }

        return true;    }
}