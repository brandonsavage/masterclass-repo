<?php

$di = new Aura\Di\Container(new \Aura\Di\Factory());

$di->setAutoResolve(false);

$db = $config['database'];

$dsn = sprintf('mysql:host=%s;dbname=%s', $db['host'], $db['name']);

$di->params['PDO'] = [
    'dsn' => $dsn,
    'username' => $db['user'],
    'passwd' => $db['pass'],
    'options' => [
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION,
    ],
];

$di->params[Masterclass\Request::class] = [
    'post' => $_POST,
    'get' => $_GET,
];

$di->params[Masterclass\Controller\Index::class] = [
    'model' => $di->lazyNew(Masterclass\Model\Story::class),
];

$di->params[Masterclass\Model\Story::class] = [
    'pdo' => $di->lazyNew('PDO'),
];

$di->params[Masterclass\Controller\User::class] = [
    'model' => $di->lazyNew(Masterclass\Model\User::class),
    'request' => $di->lazyNew(Masterclass\Request::class),
];

$di->params[Masterclass\Model\User::class] = [
    'pdo' => $di->lazyNew('PDO'),
];

$di->params[Masterclass\Controller\Comment::class] = [
    'comment' => $di->lazyNew(Masterclass\Model\Comment::class),
    'request' => $di->lazyNew(Masterclass\Request::class),
];

$di->params[Masterclass\Model\Comment::class] = [
    'pdo' => $di->lazyNew('PDO'),
];
$di->params[Masterclass\Controller\Story::class] = [
    'story' => $di->lazyNew(Masterclass\Model\Story::class),
    'comment' => $di->lazyNew(Masterclass\Model\Comment::class),
    'request' => $di->lazyNew(Masterclass\Request::class),
];
