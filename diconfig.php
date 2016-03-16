<?php

use Masterclass\Controller;
use Aura\Di\Container;
use Aura\Di\Factory;

$di = new Container(new Factory());

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

$di->params[Masterclass\Db\Mysql::class] = [
    'pdo' => $di->lazyNew('PDO'),
];

$di->params[Masterclass\Request::class] = [
    'post' => $_POST,
    'get' => $_GET,
    'server' => $_SERVER,
];
$di->set('request', $di->lazyNew(Masterclass\Request::class));

$di->params[Masterclass\Controller\Index::class] = [
    'model' => $di->lazyNew(Masterclass\Model\StoryMysqlDataStore::class),
];

$di->params[Masterclass\Model\StoryMysqlDataStore::class] = [
    'dataStore' => $di->lazyNew(Masterclass\Db\Mysql::class),
];

$di->params[Masterclass\Controller\User::class] = [
    'model' => $di->lazyNew(Masterclass\Model\UserMysqlDataStore::class),
    'request' => $di->get('request'),
];

$di->params[Masterclass\Model\UserMysqlDataStore::class] = [
    'dataStore' => $di->lazyNew(Masterclass\Db\Mysql::class),
];

$di->params[Masterclass\Controller\Comment::class] = [
    'comment' => $di->lazyNew(Masterclass\Model\CommentMysqlDataStore::class),
    'request' => $di->get('request'),
];

$di->params[Masterclass\Model\CommentMysqlDataStore::class] = [
    'dataStore' => $di->lazyNew(Masterclass\Db\Mysql::class),
];
$di->params[Masterclass\Controller\Story::class] = [
    'story' => $di->lazyNew(Masterclass\Model\StoryMysqlDataStore::class),
    'comment' => $di->lazyNew(Masterclass\Model\CommentMysqlDataStore::class),
    'request' => $di->get('request'),
];

$di->params[Masterclass\RouteMap::class] = [
    'dispatcher' => FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/', Controller\Index::class . ':index');
        $r->addRoute('GET', '/story/[{id:\d+}]', Controller\Story::class . ':index');
        $r->addRoute('GET', '/story/create', Controller\Story::class . ':create');
        $r->addRoute('POST', '/story/create', Controller\Story::class . ':create');
        $r->addRoute('POST', '/comment/create', Controller\Comment::class . ':create');
        $r->addRoute('GET', '/user/create', Controller\User::class . ':create');
        $r->addRoute('POST', '/user/create', Controller\User::class . ':create');
        $r->addRoute('GET', '/user/account', Controller\User::class . ':account');
        $r->addRoute('POST', '/user/account', Controller\User::class . ':account');
        $r->addRoute('GET', '/user/login', Controller\User::class . ':login');
        $r->addRoute('POST', '/user/login', Controller\User::class . ':login');
        $r->addRoute('GET', '/user/logout', Controller\User::class . ':logout');
    }),
    'request' => $di->get('request'),
];
