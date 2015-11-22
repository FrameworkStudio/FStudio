<?php

namespace FStudio\interfaces;

/**
 * Interfaz para ser aplicada a los controladores que manejan una sola acción
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @version 1.0.0
 * @package FStudio
 * @subpackage interfaces
 */
interface fsAction {

  /**
   * Método principal para ejecutar una acción
   */
  public function execute();
}
