<?php

$di = new Aura\Di\Container(new \Aura\Di\Factory());

$db = $config['database'];

$dsn = sprintf('mysql:host=%s;dbname=%s', $db['host'], $db['name']);

$di->params['PDO'] = [
    'dsn' => $dsn,
    'username' => $db['user'],
    'passwd' => $db['pass'],
];

$di->params[Masterclass\Controller\Index::class] = [
    'model' => $di->lazyNew(Masterclass\Model\Story::class),
];

$di->params[Masterclass\Model\Story::class] = [

];
