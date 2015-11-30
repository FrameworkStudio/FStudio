<?php

require_once '../libs/vendor/FStudio/fsDispatch.class.php';
require_once '../libs/vendor/FStudio/fsConfig.class.php';
require_once '../libs/vendor/FStudio/fsView.class.php';
require_once '../config/myConfig.class.php';
require_once '../config/config.php';

session_name($config->getSessionName());
session_start();

use FStudio\fsDispatch as dispath;
use FStudio\fsView as view;

$dispath = new dispath($config, new view());
$dispath->run();
