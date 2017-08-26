<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 18:19
 */

namespace Masterclass\Event\Listeners;


use Masterclass\Event\Events\UserCreated;

class QueueUserForSalesCall
{
    public function execute(UserCreated $event)
    {
        var_dump('Queued user ' . $event->username . ' for sales call');
    }
}