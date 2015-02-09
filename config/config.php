<?php

return array(

    'database' => array(
        'user' => 'masterclass',
        'pass' => 'ch4ng3m3;',
        'host' => 'localhost',
        'name' => 'masterclass',
    ),
    
    'routes' => array(
        '' => 'Jsposato\Controller\IndexController:index',
        'story' => 'Jsposato\Controller\StoryController:index',
        'story/create' => 'Jsposato\Controller\StoryController:create',
        'comment/create' => 'Jsposato\Controller\CommentController:create',
        'user/create' => 'Jsposato\Controller\UserController:create',
        'user/account' => 'Jsposato\Controller\UserController:account',
        'user/login' => 'Jsposato\Controller\UserController:login',
        'user/logout' => 'Jsposato\Controller\UserController:logout',
    ),
);
