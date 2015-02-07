<?php

return array(

    'database' => array(
        'user' => 'masterclass',
        'pass' => 'ch4ng3m3;',
        'host' => 'localhost',
        'name' => 'masterclass',
    ),
    
    'routes' => array(
        '' => 'index/index',
        'story' => 'story/index',
        'story/create' => 'story/create',
        'comment/create' => 'comment/create',
        'user/create' => 'user/create',
        'user/account' => 'user/account',
        'user/login' => 'user/login',
        'user/logout' => 'user/logout',
    ),
);
