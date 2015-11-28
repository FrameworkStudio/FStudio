<?php

use FStudio\fsController as controller;

/**
 * Controlador para las acciones de la implementación MVC
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage controller
 * @subpackage exception
 * @version 1.0.0
 */
class FStudio extends controller {

  /**
   * Método principal para la ejecución visual de la excepción
   * @version 1.0.0
   * @param PDOException $exc
   */
  public function exception(PDOException $exc) {
    $this->exc = $exc;
    $this->defineView('FStudio', 'exception', 'html');
  }

  /**
   * Método principal para la primera ejecución despues de instalar
   * @version 1.0.0
   */
  public function wellcome() {
    $this->mensaje = "Wellcome to FrameWork Studio";
    $this->defineView('FStudio', 'wellcome', 'html');
  }
  
}
