<?php

return array(

    'database' => array(
        'user' => 'masterclass',
        'pass' => 'ch4ng3m3;',
        'host' => 'localhost',
        'name' => 'masterclass',
    ),
    
    'routes' => array(
        '/' => ['class' => 'Jsposato\Controller\IndexController:index', 'type' => 'GET'],
        '/story' => ['class' => 'Jsposato\Controller\StoryController:index', 'type' => 'GET'],
        '/story/create' => ['class' => 'Jsposato\Controller\StoryController:create', 'type' => 'GET'],
        '/story/create/save' => ['class' => 'Jsposato\Controller\StoryController:create', 'type' => 'POST'],
        '/comment/create' => ['class' => 'Jsposato\Controller\CommentController:create', 'type' => 'POST'],
        '/user/create' => ['class' => 'Jsposato\Controller\UserController:create', 'type' => 'GET'],
        '/user/account/create' => ['class' => 'Jsposato\Controller\UserController:create', 'type' => 'POST'],
        '/user/account' => ['class' => 'Jsposato\Controller\UserController:account', 'type' => 'GET'],
        '/user/account/save' => ['class' => 'Jsposato\Controller\UserController:account', 'type' => 'POST'],
        '/user/login/check' => ['class' => 'Jsposato\Controller\UserController:login', 'type' => 'POST'],
        '/user/login' => ['class' => 'Jsposato\Controller\UserController:login', 'type' => 'GET'],
        '/user/logout' => ['class' => 'Jsposato\Controller\UserController:logout', 'type' => 'GET']
    ),
);
