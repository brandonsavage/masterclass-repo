<?php

session_start();

require '../vendor/autoload.php';

$config = require_once('../config.php');

$framework = new MasterController($config);
echo $framework->execute();