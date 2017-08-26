<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/23/17
 * Time: 12:12
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;
use Aura\Payload\PayloadFactory;
use Masterclass\Model\Stories\StoryGateway;
use Masterclass\Model\Stories\StoryReadService;
use Masterclass\Model\Stories\StoryWriteService;
use Masterclass\Model\Users\UserGateway;
use Masterclass\Model\Users\UserReadService;
use Masterclass\Model\Users\UserWriteService;

class Models extends Config
{
    public function define(Container $di)
    {

        $di->params[\Masterclass\Dbal\Database::class] = [
            'pdo' => $di->lazyGet('Pdo'),
        ];

        $di->params[\Masterclass\Dbal\Decorators\Apc::class] = [
            'dbal' => $di->lazyGet('Dbal.Database'),
        ];

        $di->set('Dbal.Database', $di->lazyNew(\Masterclass\Dbal\Database::class));
        $di->set('Dbal.Apc', $di->lazyNew(\Masterclass\Dbal\Decorators\Apc::class));

        $di->params[\Masterclass\Model\Comment::class] = [
            'pdo' => $di->lazyGet('Pdo'),
        ];

        // Story Model
        $di->params[\Masterclass\Model\Stories\StoryGateway::class] = [
            'storage' => $di->lazyNew(\Masterclass\Model\Stories\StoryStorage::class),
        ];

        $di->params[\Masterclass\Model\Stories\StoryStorage::class] = [
            'database' => $di->lazyGet('Dbal.Database'),
        ];

        // User Model
        $di->params[\Masterclass\Model\Users\UserGateway::class] = [
            'storage' => $di->lazyNew(\Masterclass\Model\Users\UserStorage::class),
        ];

        $di->params[\Masterclass\Model\Users\UserStorage::class] = [
            'dbal' => $di->lazyGet('Dbal.Database'),
        ];

        // Services
        $di->params[StoryReadService::class] = [
            'gateway' => $di->lazyNew(StoryGateway::class),
            'payloadFactory' => $di->lazyNew(PayloadFactory::class),
        ];

        $di->params[StoryWriteService::class] = [
            'gateway' => $di->lazyNew(StoryGateway::class),
            'payloadFactory' => $di->lazyNew(PayloadFactory::class),
        ];

        $di->params[UserReadService::class] = [
            'gateway' => $di->lazyNew(UserGateway::class),
            'session' => $di->lazyGet('Session'),
        ];

        $di->params[UserWriteService::class] = [
            'gateway' => $di->lazyNew(UserGateway::class),
            'commandBus' => $di->lazyGet('CommandBus'),
        ];
    }
}