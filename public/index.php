<?php

session_start();

$path = realpath(__DIR__ . '/..');
require_once $path . '/vendor/autoload.php';

$config = function () use ($path) {
    return require_once $path . '/config/config.php';
};

$container_builder = new \Aura\Di\ContainerBuilder();
$di = $container_builder->newInstance(
    ['config' => $config],
    ['Masterclass\Configuration\DiConfig', 'Masterclass\Configuration\RouterConfig']
);
$framework = $di->newInstance('Masterclass\FrontController\MasterController');
echo $framework->execute();
