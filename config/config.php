<?php

use FStudio\myConfig as config;

$config = new config();
$config->setPath($_SERVER['DOCUMENT_ROOT'].'/fstudio/');
$config->setUrl('http://localhost/fstudio/web/');

$config->setDriver('mysql');
$config->setHost('localhost');
$config->setPort(false);
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
    'fsEjemplo1Plugin',
    'fsEjemplo2Plugin',
));
