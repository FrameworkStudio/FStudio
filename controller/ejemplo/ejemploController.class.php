<?php

use FStudio\fsController as controller;

/**
 * Clase controladora del módulo ejemplo
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage controller
 * @subpackage ejemplo
 * @version 1.0.0
 */
class ejemploController extends controller {

  /**
   * Acción saludar. Esta acción es un ejemplo de como pasar una variable
   * a la vista y como definir una vista.
   */
  public function saludar() {
    $this->mensaje = 'HOLA general por variable';
    $this->defineView('ejemplo', 'index', 'html');
  }

}
