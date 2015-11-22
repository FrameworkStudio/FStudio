<?php

require_once '../libs/vendor/FStudio/fsDispatch.class.php';
require_once '../libs/vendor/FStudio/fsConfig.class.php';
require_once '../config/myConfig.class.php';
require_once '../config/config.php';

session_name($config->getSessionName());
session_start();

use FStudio\fsDispatch as dispath;

$dispath = new dispath($config);
$dispath->run();
