<?php

use FStudio\myConfig as config;

$config = new config();
$config->setPath('/Applications/MAMP/htdocs/FStudio/');
$config->setUrl('http://localhost/FStudio/web/');

$config->setDriver('mysql'); // mysql, pgsql
$config->setHost('localhost');
$config->setPort(false); // 3306, 5432
$config->setDbName('fstudio');
$config->setUser('root');
$config->setPassword('root');
$config->setDsn(
        $config->getDriver()
        . ':host=' . $config->getHost()
        . ';port=' . $config->getPort()
        . ';dbname=' . $config->getDbName()
);

$config->setSessionName('FStudio');

$config->setDefaultModule('FStudio');
$config->setDefaultAction('wellcome');

$config->setPlugins(array(
    'fsEjemplo1Plugin'
));
