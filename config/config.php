<?php

use FStudio\myConfig as config;

$config = new config();

$config->setPath('/Applications/MAMP/htdocs/FStudio/');
$config->setUrl('http://localhost/FStudio/web/');

$config->setDriver('pgsql');
$config->setHost('localhost');
$config->setPort(5432);
$config->setDbName('fstudio');
$config->setUser('postgres');
$config->setPassword('sqlx32');
$config->setDsn($config->getDriver() . ':host=' . $config->getHost() . ';port=' . $config->getPort() . ';dbname=' . $config->getDbName());

$config->setSessionName('FStudio');

$config->setDefaultModule('ejemplo');
$config->setDefaultAction('index');

$config->setPlugins(array(
    'fsEjemplo1Plugin',
    'fsEjemplo2Plugin',
));