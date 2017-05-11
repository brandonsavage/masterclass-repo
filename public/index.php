<?php

session_start();

$config = require_once('../config.php');
require_once '../vendor/autoload.php';

require ('../diconfig.php');

/**
 * @var \Masterclass\RouteMap $routeMap
 */
$routeMap = $di->newInstance(Masterclass\RouteMap::class);
$destination = $routeMap->handle();
$framework = new Masterclass\MasterController($di, $config, $destination);
echo $framework->execute();
