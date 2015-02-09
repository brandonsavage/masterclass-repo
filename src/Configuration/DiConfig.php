<?php

namespace Jsposato\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;

class DiConfig extends Config
{
    public function define( Container $di ) {
        $config = $di->get('config');

        $db = $config['database'];

        $dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

        $di->params['Jsposato\Dbal\AbstractDb'] = [
            'dsn' => $dsn,
            'user' => $db['user'],
            'pass' => $db['pass']
        ];

        $di->params['Jsposato\Model\Comment'] = [
            'db' => $di->lazyNew('Jsposato\Dbal\Mysql')
        ];

        $di->params['Jsposato\Model\Story'] = [
            'db' => $di->lazyNew('Jsposato\Dbal\Mysql')
        ];

        $di->params['Jsposato\MasterController'] = [
            'container' => $di,
            'config' => $config,
            'router' => $di->lazyNew('Jsposato\Router\Router')
        ];

        $di->params['Jsposato\Controller\CommentController'] = [
            'commentModel' => $di->lazyNew('Jsposato\Model\Comment')
        ];

        $di->params['Jsposato\Controller\StoryController'] = [
            'storyModel' => $di->lazyNew('Jsposato\Model\Story'),
            'commentModel' => $di->lazyNew('Jsposato\Model\Comment')
        ];

        $di->params['Jsposato\Controller\IndexController'] = [
            'storyModel' => $di->lazyNew('Jsposato\Model\Story')
        ];

        $di->params['Jsposato\Controller\UserController'] = [
            'config' => $config
        ];
    }
}