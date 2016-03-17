<?php

session_start();

$config = require_once('../config/config.php');
require_once '../vendor/autoload.php';
require_once '../config/diconfig.php';

$framework = $di->newInstance('Masterclass\MasterController');
echo $framework->execute();
