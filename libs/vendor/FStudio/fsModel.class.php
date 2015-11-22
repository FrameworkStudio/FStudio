<?php

namespace FStudio;

/**
 * Clase para manejar el modelo del sistema<br>
 * (Maneja la conexión a la base de datos)
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @version 1.0.0
 * @package FStudio
 * @subpackage model
 */
class fsModel {

  /**
   * Atributo para manejar la instancia de la clase PDO
   * @var \PDO
   */
  static private $instance = null;

  /**
   * Obtiene la instance de la conexión a la base de datos
   * @return \PDO
   */
  protected function getConnection(myConfig $config) {
    if (self::$instance === null) {

      // para usar conexiones persistentes
      $options = array(
          \PDO::ATTR_PERSISTENT => true
      );

      // crea la instancia de la conexión
      self::$instance = new \PDO($config->getDsn(), $config->getUser(), $config->getPassword(), $options);

      // asignación de atributos para el manejo de errores
      self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    return self::$instance;
  }

}
