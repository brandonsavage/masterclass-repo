<?php

session_start();

$path = realpath( __DIR__ . '/..');

require_once $path . '/vendor/autoload.php';

//require '../services.php';

$config = function() use ($path) {
    return require($path . '/config/config.php');
};

$diContainerBuilder = new Aura\Di\ContainerBuilder();
$di = $diContainerBuilder->newInstance(['config' => $config], ['Jsposato\Configuration\DiConfig', 'Jsposato\Configuration\RouterConfig']);

$framework = $di->newInstance('Jsposato\MasterController');
echo $framework->execute();