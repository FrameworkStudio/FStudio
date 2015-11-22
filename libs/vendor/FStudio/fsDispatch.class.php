<?php

namespace FStudio;

/**
 * Versión actual de la línea base (Framework Studio)
 */
define('FS_VERSION', '1.0.0');

/**
 * Clase para manejar el controlador frontal
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @version 1.0.0
 * @package FStudio
 * @subpackage dispatch
 */
class fsDispatch {

  /**
   * Configuración del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var myConfig
   */
  private $config;

  /**
   * Módulo a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $module;

  /**
   * Acción a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $action;

  /**
   * Identifica (true) si ejecuta un controlador para una acción<br>
   * o (false) si ejecuta un controlador con muchas acciones
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $actionOractions;

  /**
   * Instancia del controlador a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var fsController
   */
  private $controller;

  /**
   * Plantilla para cargar un controlador con muchas acciones
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   */
  const ACTIONS = '%path%controller/%module%/%module%.class.php';

  /**
   * Plantilla para cargar el controlador de una acción
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   */
  const ACTION = '%path%controller/%module%/%action%.class.php';

  /**
   * Constructor de la clase fsDispatch
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param \FStudio\myConfig $config Configuración del sistema
   */
  public function __construct(myConfig $config) {
    $this->config = $config;
  }

  /**
   * Método principal que inicia el sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   */
  public function run() {
    try {
      $this->loadBasicFiles();
      $this->setRouting();
      $this->loadAndExecutePlugins();
      $this->loadModuleAndAction();
      $this->executeController();
      $this->renderView();
    } catch (\PDOException $exc) {
      require_once $this->config->getPath() . 'controller/FStudio/FStudio.class.php';
      $this->controller = new \FStudio($this->config);
      $this->controller->exception($exc);
      $this->renderView();
    }
  }

  /**
   * Carga los archivos base para la ejecución del sistema
   */
  private function loadBasicFiles() {
    $files = array(
        'libs/vendor/FStudio/fsModel.class.php',
        'libs/vendor/FStudio/fsView.class.php',
        'libs/vendor/FStudio/fsController.class.php',
        'libs/vendor/FStudio/interfaces/fsAction.interface.php'
    );
    foreach ($files as $file) {
      require_once $this->config->getPath() . $file;
    }
  }

  /**
   * Fija el modulo y acción solicitados al sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   */
  private function setRouting() {
    if (isset($_SERVER['PATH_INFO']) === true) {
      $data = explode('/', $_SERVER['PATH_INFO']);
      $this->module = isset($data[1]) === true ? $data[1] : null;
      $this->action = isset($data[2]) === true ? $data[2] : null;
      if ($this->module === null) {
        throw new \PDOException('Escriba una dirección válida');
      }
      if ($this->action === null) {
        throw new \PDOException('Escriba una dirección válida');
      }
    } else {
      $this->module = $this->config->getDefaultModule();
      $this->action = $this->config->getDefaultAction();
    }
  }

  /**
   * Carga y ejecuta los plugins configurados en el sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @throws \PDOException
   */
  private function loadAndExecutePlugins() {
    if (is_array($this->config->getPlugins()) === true and count($this->config->getPlugins()) > 0) {
      foreach ($this->config->getPlugins() as $plugin) {
        $path = $this->config->getPath() . 'libs/plugins/' . $plugin;
        if (is_dir($path) === false) {
          throw new \PDOException('El plugin ' . $plugin . ' no existe');
        }
        $file = $path . '/plugin.php';
        if (is_file($file) === false) {
          throw new \PDOException('El archivo de inicio (plugin.php) no existe');
        }
        require_once $file;
      }
    }
  }

  /**
   * Carga el archivo referente al módulo y acción solicitado
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @throws \PDOException
   */
  private function loadModuleAndAction() {
    $actions = strtr(self::ACTIONS, array(
        '%path%' => $this->config->getPath(),
        '%module%' => $this->module,
    ));
    $action = strtr(self::ACTION, array(
        '%path%' => $this->config->getPath(),
        '%module%' => $this->module,
        '%action%' => $this->action,
    ));
    if (file_exists($action) === true) {
      require_once $action;
      $this->actionOractions = true;
    } else if (file_exists($actions)) {
      require_once $actions;
      $this->actionOractions = false;
    } else {
      throw new \PDOException('El módulo y acción solicitada, no existe');
    }
  }

  /**
   * Ejecuta el controlador solicitado
   */
  private function executeController() {
    switch ($this->actionOractions) {
      case true:
        $this->controller = new $this->action($this->config);
        $this->controller->execute();
        break;
      case false;
        $this->controller = new $this->module($this->config);
        if (method_exists($this->controller, $this->action) === false) {
          throw new \PDOException('La acción solicitadad no existe');
        }
        $this->controller->{$this->action}();
        break;
    }
  }

  /**
   * Renderiza la vista en el navegador
   */
  private function renderView() {
    $view = new fsView($this->config, $this->controller->getViewModule(), $this->controller->getViewName(), $this->controller->getViewFormat());
    $view->assignVariables((array) $this->controller);
    $view->renderView();
  }

}
