<?php

session_start();

$path = realpath( __DIR__ . '/..');

$config = require_once $path . '/config/config.php';

require_once $path . '/vendor/autoload.php';

require_once( '../config/diconfig.php' );

require '../services.php';

$framework = $di->newInstance('Jsposato\MasterController');
echo $framework->execute();