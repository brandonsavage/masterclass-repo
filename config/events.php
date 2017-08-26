<?php

$config['events'] = [
    \Masterclass\Event\Events\UserCreated::class => [
        \Masterclass\Event\Listeners\SendUserWelcomeEmail::class,
        \Masterclass\Event\Listeners\QueueUserForSalesCall::class,
    ],
];