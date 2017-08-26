<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/23/17
 * Time: 12:14
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;
use Masterclass\Responder\ResponseManager;

class MasterController extends Config
{
    public function define(Container $di)
    {
        $di->params[\Masterclass\MasterController::class] = [
            'responseManager' => $di->lazyNew(ResponseManager::class),
            'router' => $di->lazyGet('Router'),
            'container' => $di,
        ];
    }
}