<?php

require_once '../model/base/usuarioBaseTable.class.php';
require_once '../model/usuarioTable.class.php';

use FStudio\fsController as controller;
use FStudio\interfaces\fsAction as action;

/**
 * Clase de la acción index del módulo ejemplo
 *
 * @package FStudio
 * @subpackage controller
 * @subpackage ejemplo
 * @version 1.0.0
 */
class index extends controller implements action {

  public function execute() {

    $this->mensaje = 'Hola mundo por variable';
    
    $usuario = new usuarioTable($this->getConfig());
    $this->objUsuario = $usuario->getAll();

    $this->defineView('ejemplo', 'index', 'html');
  }

}
