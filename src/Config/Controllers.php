<?php

namespace Masterclass\Config;

use Aura\Di\Config;
use Aura\Di\Container;
use Masterclass\Model\Stories\StoryReadService;
use Masterclass\Model\Stories\StoryWriteService;
use Masterclass\Model\Users\UserGateway;
use Masterclass\Model\Users\UserReadService;
use Masterclass\Model\Users\UserWriteService;

class Controllers extends Config
{
    public function define(Container $di)
    {
        $di->params[\Masterclass\Controller\Index::class] = [
            'storyModel' => $di->lazyNew(StoryReadService::class),
            'view' => $di->lazyGet('View'),
        ];

        $di->params[\Masterclass\Controller\Story::class] = [
            'storyModel' => $di->lazyNew(\Masterclass\Model\Stories\StoryReadService::class),
            'storyWriteService' => $di->lazyNew(StoryWriteService::class),
            'commentModel' => $di->lazyNew(\Masterclass\Model\Comment::class),
            'request' => $di->lazyGet('Request'),
            'session' => $di->lazyGet('Session'),
            'view' => $di->lazyGet('View'),
        ];

        $di->params[\Masterclass\Controller\Comment::class] = [
            'commentModel' => $di->lazyNew(\Masterclass\Model\Comment::class),
            'request' => $di->lazyGet('Request'),
            'session' => $di->lazyGet('Session'),
        ];

        $di->params[\Masterclass\Controller\User::class] = [
            'request' => $di->lazyGet('Request'),
            'session' => $di->lazyGet('Session'),
            'view' => $di->lazyGet('View'),
            'readService' => $di->lazyNew(UserReadService::class),
            'writeService' => $di->lazyNew(UserWriteService::class),
        ];
    }
}