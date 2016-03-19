<?php

session_start();

$path = realpath(__DIR__ . '/..');
require_once $path . '/vendor/autoload.php';
$configuration = require_once $path . '/config/config.php';
$config = function () use ($configuration) {
    return $configuration;
};

$container_builder = new \Aura\Di\ContainerBuilder();
$di = $container_builder->newInstance(
    ['config' => $config],
    $configuration['config_classes']
);
$framework = $di->newInstance('Masterclass\FrontController\MasterController');
echo $framework->execute();
