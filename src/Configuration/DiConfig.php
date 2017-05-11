<?php

namespace Masterclass\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;

class DiConfig extends Config
{
    public function define(Container $di)
    {
        $config = $di->get('config');

        $dbconfig = $config['database'];

        $dsn = "mysql:host={$dbconfig['host']};dbname={$dbconfig['name']}";
        $di->params['Masterclass\Dbal\AbstractDb'] = [
            'dsn' => $dsn,
            'user' => $dbconfig['user'],
            'pass' => $dbconfig['pass'],
        ];

        $di->params['Masterclass\Model\Story'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];
        $di->params['Masterclass\Model\Comment'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];
        $di->params['Masterclass\Model\User'] = [
            'db' => $di->lazyNew('Masterclass\Dbal\Mysql')
        ];


        $di->params['Masterclass\Controller\Index'] = [
            'story_model' => $di->lazyNew('Masterclass\Model\Story')
        ];
        $di->params['Masterclass\Controller\Comment'] = [
            'comment_model' => $di->lazyNew('Masterclass\Model\Comment')
        ];
        $di->params['Masterclass\Controller\Story'] = [
            'comment_model' => $di->lazyNew('Masterclass\Model\Comment'),
            'story_model' => $di->lazyNew('Masterclass\Model\Story')
        ];
        $di->params['Masterclass\Controller\User'] = [
            'user_model' => $di->lazyNew('Masterclass\Model\User')
        ];

        $di->params['Masterclass\FrontController\MasterController'] = [
            'container' => $di,
            'config' => $config,
            'router' => $di->lazyNew('Masterclass\Router\Router'),
        ];
    }
}
