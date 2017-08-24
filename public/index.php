<?php

session_start();

$config = require_once('../config/config.php');
require '../vendor/autoload.php';

// Services need to be callables.
$services['config'] = function() use ($config) {
    return $config;
};

$diContainer = new \Aura\Di\ContainerBuilder();
$di = $diContainer->newInstance(
    $services,
    $config['classes'],
    Aura\Di\ContainerBuilder::DISABLE_AUTO_RESOLVE
);

//require '../diconfig.php';

//$framework = $di->get(Masterclass\MasterController::class);
$framework = $di->newInstance(Masterclass\MasterController::class);
echo $framework->execute();