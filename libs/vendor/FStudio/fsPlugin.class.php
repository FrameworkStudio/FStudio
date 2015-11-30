<?php

namespace FStudio;

use FStudio\myConfig as config;

/**
 * Description of fsPlugin
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 */
class fsPlugin {

  /**
   * Configuración del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var config
   */
  protected $config;

  public function __construct(myConfig $config) {
    $this->config = $config;
  }

}
