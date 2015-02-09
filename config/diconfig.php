<?php

$di = new Aura\Di\Container(new Aura\Di\Factory());

$db = $config['database'];

$dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

$di->params['PDO'] = [
    'dsn' => $dsn,
    'username' => $db['user'],
    'passwd' => $db['pass']
];

$di->params['Jsposato\Model\Comment'] = [
    'pdo' => $di->lazyNew( 'PDO' )
];

$di->params['Jsposato\Model\Story'] = [
    'pdo' => $di->lazyNew( 'PDO' )
];

$di->params['Jsposato\Controller\CommentController'] = [
    'commentModel' => $di->lazyNew('Jsposato\Model\COmment')
];

$di->params['Jsposato\Controller\StoryController'] = [
    'storyModel' => $di->lazyNew( 'Jsposato\Model\Story' ),
    'commentModel' => $di->lazyNew( 'Jsposato\Model\Comment' )
];

$di->params['Jsposato\Controller\Index'] = [
    'storyModel' => $di->lazyNew( 'Jsposato\Model\Story' )
];

$di->params['Jsposato\Controller\UserController'] = [
    'config' => $config
];
