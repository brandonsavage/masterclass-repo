<?php

use Masterclass\Utils\MasterRouter;

define('__BASE_DIR__', dirname(__DIR__) . '/');

session_start();

require_once '../vendor/autoload.php';

$framework = new MasterRouter();
echo $framework->execute();
