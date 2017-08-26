<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 18:23
 */

namespace Masterclass\Event;


abstract class EventDispatcher
{
    /**
     * @var EventBus
     */
    protected static $eventBus;

    static public function loadEventBus(EventBus $eventBus)
    {
        self::$eventBus = $eventBus;
    }

    static public function dispatch($event)
    {
        self::$eventBus->dispatch($event);
    }
}