<?php

session_start();

$config = require_once('../config.php');
require_once '../src/MasterController.php';

require_once '../src/Comment.php';
require_once '../src/User.php';
require_once '../src/Story.php';
require_once '../src/Index.php';

$framework = new MasterController($config);
echo $framework->execute();