<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 18:13
 */

namespace Masterclass\Event;


use Masterclass\Event\Exceptions\InvalidEvent;

class EventBus
{
    /**
     * @var array
     */
    protected $eventListeners = [];

    public function __construct(array $eventListeners)
    {
        $this->eventListeners = $eventListeners;
    }

    public function dispatch($event)
    {
        $eventClass = get_class($event);

        if (!isset($this->eventListeners[$eventClass])) {
            throw new InvalidEvent();
        }

        foreach ($this->eventListeners[$eventClass] as $eventListener) {
            $eventListener->execute($event);
        }
    }
}