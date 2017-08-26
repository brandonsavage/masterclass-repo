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
use Masterclass\Command\Handlers\CreateUser;
use Masterclass\Event\EventBus;
use Masterclass\Event\EventDispatcher;
use Masterclass\Model\Users\UserGateway;

class Events extends Config
{
    public function define(Container $di)
    {
        /**
         * Event Bus Setup
         */
        $config = $di->get('config');
        $di->set('EventBus', function () use ($di, $config) {
            $events = $config['events'];
            $eventArray = [];
            foreach($events as $event => $listeners) {
                $listenersArray = [];
                foreach ($listeners as $listener) {
                    $listenersArray[] = $di->newInstance($listener);
                }
                $eventArray[$event] = $listenersArray;
            }

            return $di->newInstance(EventBus::class, [$eventArray]);
        });

        /**
         * Event Setup
         */
    }

    public function modify(Container $di)
    {
        EventDispatcher::loadEventBus($di->get('EventBus'));
    }
}