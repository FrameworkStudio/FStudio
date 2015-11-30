<?php

namespace fsEjemplo1Plugin;

use FStudio\fsPlugin;
use FStudio\myConfig as config;

class plugin extends fsPlugin {
  
  public function __construct(config $config) {
    parent::__construct($config);
    echo 'Versión de FStudio ' . FS_VERSION . '<br>';
    echo 'Hola desde un plugin 1<br>';
  }
  
}
