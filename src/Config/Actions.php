<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 8/26/17
 * Time: 9:08 AM
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;
use Masterclass\Action\IndexAction;
use Masterclass\Model\Stories\StoryReadService;

class Actions extends Config
{
    public function define(Container $di)
    {
        $di->params[IndexAction::class] = [
            'storyRead' => $di->lazyNew(StoryReadService::class),
        ];
    }
}