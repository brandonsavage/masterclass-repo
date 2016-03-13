<?php

session_start();

$config = require_once('../config.php');
require_once '../vendor/autoload.php';

require ('../diconfig.php');

$framework = new Masterclass\MasterController($di, $config);
echo $framework->execute();
