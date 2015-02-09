<?php

// instantiate Aura DI container
$di = new \Aura\Di\Container( new \Aura\Di\Factory());

$di->params['Jsposato\MasterController'] = [
    'container' => $di,
    'config' => $config
];

$di->params['Jsposaot\Controller\IndexController'] = [
    'story' => $di->lazyNew('Jsposato\Model\Story'),
    'comment' => $di->lazyNew('Jsposato\Model\Comment')
];

$di->params['Jsposato\Mdeol\Story'] = [
    'pdo' => $di->lazyNew('PDO')
];

$di->params['PDO'] = [
    'dsn' => 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['name'],
    'username' => $config['database']['user'],
    'passwd' => $config['database']['pass']
];