<?php

$di = new \Masterclass\Container();

/** Controllers */
$di->set(\Masterclass\Controller\Index::class, function () use ($di) {
    return new \Masterclass\Controller\Index($di->get(\Masterclass\Model\Story::class));
});

$di->set(\Masterclass\Controller\Story::class, function () use ($di) {
    return new \Masterclass\Controller\Story(
        $di->get(Masterclass\Model\Story::class),
        $di->get(Masterclass\Model\Comment::class),
        $di->get(Masterclass\Request::class)
    );
});

$di->set(\Masterclass\Controller\Comment::class, function () use ($di) {
    return new Masterclass\Controller\Comment(
        $di->get(Masterclass\Model\Comment::class),
        $di->get(Masterclass\Request::class)
    );
});

$di->set(Masterclass\Controller\User::class, function () use ($di) {
    return new Masterclass\Controller\User(
        $di->get(Masterclass\Request::class),
        $di->get('PDO')
    );
});

/** Models */
$di->set(Masterclass\Model\Story::class, function () use ($di) {
    return new Masterclass\Model\Story($di->get('PDO'));
});

$di->set(Masterclass\Model\Comment::class, function () use ($di) {
    return new Masterclass\Model\Comment($di->get('PDO'));
});

/** Services */
$di->set(Masterclass\MasterController::class, function () use ($di) {
    return new \Masterclass\MasterController(
        $di->get(Masterclass\Request::class),
        $di->get(Masterclass\Router\Router::class),
        $di
    );
});


$di->set('PDO', function() use ($config) {
    $dbconfig = $config['database'];
    $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
    $db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
});

$di->set(\Masterclass\Request::class, function() {
    return new Masterclass\Request($GLOBALS);
});

$di->set(Masterclass\Router\Router::class, function () use ($di, $config) {
    $routes = [];

    foreach ($config['routes'] as $path => $route) {
        if ($route['method'] == 'GET') {
            $route = new \Masterclass\Router\Routes\GetRoute($path, $route);
        } else {
            $route = new \Masterclass\Router\Routes\PostRoute($path, $route);
        }

        $routes[] = $route;
    }

    return new \Masterclass\Router\Router($di->get(Masterclass\Request::class), $routes);
});