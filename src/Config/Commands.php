<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 17:37
 */

namespace Masterclass\Config;


use Aura\Di\Config;
use Aura\Di\Container;
use Masterclass\Command\CommandBus;
use Masterclass\Command\Handlers\CreateUser;
use Masterclass\Model\Users\UserGateway;

class Commands extends Config
{
    public function define(Container $di)
    {
        /**
         * Command Bus Setup
         */
        $config = $di->get('config');
        $di->set('CommandBus', function () use ($di, $config) {
            $commands = $config['commands'];
            $commandArray = [];
            foreach($commands as $command => $handler) {
                $commandArray[$command] = $di->newInstance($handler);
            }

            return $di->newInstance(CommandBus::class, [$commandArray]);
        });

        /**
         * Command Setup
         */

        $di->params[CreateUser::class] = [
            'userGateway' => $di->lazyNew(UserGateway::class),
        ];
    }
}