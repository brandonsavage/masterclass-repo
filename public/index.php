<?php

session_start();

require_once '../vendor/autoload.php';
$config = require_once '../config.php';

require_once '../src/FrontController.php';

$framework = new Masterclass\FrontController($config);
echo $framework->execute();