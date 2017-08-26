<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/26/17
 * Time: 9:10 AM
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;
use Masterclass\Responder\IndexResponder;
use Masterclass\Responder\ResponseManager;

class Responders extends Config
{
    public function define(Container $di)
    {
        // Configuration for generic responder manager
        $di->params[ResponseManager::class] = [
            'accept' => $di->lazyNew(\Aura\Accept\Accept::class),
        ];

        // Configuration for responders
        $di->params[IndexResponder::class] = [
            'response' => $di->lazyGet('Response'),
            'view' => $di->lazyGet('View'),
        ];
    }
}