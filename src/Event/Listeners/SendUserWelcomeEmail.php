<?php
/**
 * Created by PhpStorm.
 * User: brandon
 * Date: 6/28/17
 * Time: 18:18
 */

namespace Masterclass\Event\Listeners;


use Masterclass\Event\Events\UserCreated;

class SendUserWelcomeEmail
{
    public function execute(UserCreated $event)
    {
        var_dump('Sent email to ' . $event->username);
    }
}