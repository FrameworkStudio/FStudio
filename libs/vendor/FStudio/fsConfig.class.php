<?php

namespace FStudio;

/**
 * Clase para manejar la configuración básica del sistema
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @version 1.0.0
 * @package FStudio
 * @subpackage config
 */
class fsConfig {

  /**
   * Módulo por defecto del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $defaultModule;

  /**
   * Acción por defecto del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $defaultAction;

  /**
   * Dirección física del proyecto en el servidor
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $path;

  /**
   * Dirección URL del proyecto
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $url;

  /**
   * Nombre de la sessión del proyecto
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $sessionName;

  /**
   * Controlador a usar para la base de datos<br>
   * Ejemplo: mysql, pgsql
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $driver;

  /**
   * Dirección IP de la base de datos<br>
   * Ejemplo: localhost, 127.0.0.1
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $host;

  /**
   * Puerto de conexión a la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var integer
   */
  private $port;

  /**
   * Usuario de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $user;

  /**
   * Contraseña de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $password;

  /**
   * Nombre de la base de datos
   * @var string
   */
  private $dbName;

  /**
   * Configuración del DSN para usar con la librería PDO<br>
   * mysql:host=localhost;port=3306;dbname=restaurante
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $dsn;

  /**
   * Array numérico con los plugins y orden a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var array
   */
  private $plugins;

  /**
   * Obtiene el módulo por defecto del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getDefaultModule() {
    return $this->defaultModule;
  }

  /**
   * Obtiene la acción por defecto del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getDefaultAction() {
    return $this->defaultAction;
  }

  /**
   * Obtiene la dirección física del proyecto en el servidor
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Obtiene la direción URL del proyecto
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * Obtiene el nombre de sesión para el proyecto
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getSessionName() {
    return $this->sessionName;
  }

  /**
   * Obtiene el controlador de la base de datos<br>
   * Ejemplo mysql, pgsql
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getDriver() {
    return $this->driver;
  }

  /**
   * Obtiene el host o direción IP de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getHost() {
    return $this->host;
  }

  /**
   * Obtiene el puerto de conexión de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return integer
   */
  public function getPort() {
    return $this->port;
  }

  /**
   * Obtiene el usuario de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getUser() {
    return $this->user;
  }

  /**
   * Obtiene la contraseña de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * Obtiene el nombre de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  public function getDbName() {
    return $this->dbName;
  }

  /**
   * Obtiene el DSN para la conexión a la base de datos<br>
   * Ejemplo: mysql:host=localhost;port=3306;dbname=restaurante
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string DSN
   */
  public function getDsn() {
    return $this->dsn;
  }

  /**
   * Obtiene el listado de plugins habilitados en el sistema<br>
   * Ejemplo: array('fsSecurity', 'fsRouting', 'fsRequest')
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return array
   */
  public function getPlugins() {
    return $this->plugins;
  }

  /**
   * Fija el módulo por defecto del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $defaultModule Módulo por defecto
   */
  public function setDefaultModule($defaultModule) {
    $this->defaultModule = $defaultModule;
  }

  /**
   * Fija la acción por defecto del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $defaultAction Acción por defecto
   */
  public function setDefaultAction($defaultAction) {
    $this->defaultAction = $defaultAction;
  }

  /**
   * Fija la dirección física del proyecto en el servidor
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $path Dirección física del proyecto
   */
  public function setPath($path) {
    $this->path = $path;
  }

  /**
   * Fija la dirección URL del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $url
   */
  public function setUrl($url) {
    $this->url = $url;
  }

  /**
   * Fija el nombre de sesión para el proyecto
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $sessionName Nombre de sesión
   */
  public function setSessionName($sessionName) {
    $this->sessionName = $sessionName;
  }

  /**
   * Fija el controlador de la base de datos<br>
   * Ejemplo mysql, pgsql
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $driver Controlador de base de datos
   */
  public function setDriver($driver) {
    $this->driver = $driver;
  }

  /**
   * Fija el host o direción IP de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $host Host o dirección IP
   */
  public function setHost($host) {
    $this->host = $host;
  }

  /**
   * Fija el puerto de conexión de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param integer $port Puerto de conexión
   */
  public function setPort($port) {
    $this->port = $port;
  }

  /**
   * Obtiene el usuario de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $user Usuario de base de datos
   */
  public function setUser($user) {
    $this->user = $user;
  }

  /**
   * Obtiene la contraseña de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $password Contraseña de la base de datos
   */
  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * Fija el nombre de la base de datos
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $dbName Nombre de base de datos
   */
  public function setDbName($dbName) {
    $this->dbName = $dbName;
  }

  /**
   * Obtiene el DSN para la conexión a la base de datos<br>
   * Ejemplo: mysql:host=localhost;port=3306;dbname=restaurante
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $dsn DSN para PDO
   */
  public function setDsn($dsn) {
    $this->dsn = $dsn;
  }

  /**
   * Fija en una array numéricos los plugins del sistema en el orden<br>
   * respectivo de ejecución
   * @param array $plugins Array con listado de plugins
   */
  public function setPlugins($plugins) {
    $this->plugins = $plugins;
  }

}
