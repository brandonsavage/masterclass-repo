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

        $di->params[\Masterclass\Model\Story::class] = [
            'pdo' => $di->lazyGet('Dbal.Database'),
        ];

        $di->params[\Masterclass\Model\Comment::class] = [
            'pdo' => $di->lazyGet('Pdo'),
        ];
    }
}