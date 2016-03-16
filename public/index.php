<?php


session_start();

$config = require_once('../config.php');
require_once('../vendor/autoload.php');


$framework = new \Masterclass\FrontController\MasterController($config);
echo $framework->execute();