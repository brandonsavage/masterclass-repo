<?php

$builder = new \Aura\Di\ContainerBuilder();
$di = $builder->newInstance(false); // auto resolve = off

$dbconfig = $config['database'];
$dsn = "mysql:host={$dbconfig['host']};dbname={$dbconfig['name']}";
$di->params['PDO'] = [
    'dsn' => $dsn,
    'username' => $dbconfig['user'],
    'passwd' => $dbconfig['pass'],
    'options' => [],
];

$di->params['Masterclass\Model\Story'] = [
    'db' => $di->lazyNew('PDO')
];
$di->params['Masterclass\Model\Comment'] = [
    'db' => $di->lazyNew('PDO')
];
$di->params['Masterclass\Model\User'] = [
    'db' => $di->lazyNew('PDO')
];


$di->params['Masterclass\Controller\Index'] = [
    'story_model' => $di->lazyNew('Masterclass\Model\Story')
];
$di->params['Masterclass\Controller\Comment'] = [
    'comment_model' => $di->lazyNew('Masterclass\Model\Comment')
];
$di->params['Masterclass\Controller\Story'] = [
    'comment_model' => $di->lazyNew('Masterclass\Model\Comment'),
    'story_model' => $di->lazyNew('Masterclass\Model\Story')
];
$di->params['Masterclass\Controller\User'] = [
    'user_model' => $di->lazyNew('Masterclass\Model\User')
];

$di->params['Masterclass\MasterController'] = [
    'container' => $di,
    'config' => $config,
];
