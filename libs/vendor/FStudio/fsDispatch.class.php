<?php

namespace FStudio;

use PDOException;

/**
 * Versión actual de la línea base (Framework Studio)
 */
define('FS_VERSION', '1.0.1');

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
  protected $config;

  /**
   * Módulo a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  protected $module;

  /**
   * Acción a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  protected $action;

  /**
   * Identifica (true) si ejecuta un controlador para una acción<br>
   * o (false) si ejecuta un controlador con muchas acciones
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  protected $actionOractions;

  /**
   * Instancia del controlador a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var fsController
   */
  protected $controller;
  
  /**
   * Instancia de la clase de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var fsView
   */
  protected $view;

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
  public function __construct(myConfig $config, fsView $view) {
    $this->config = $config;
    $this->view = $view;
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
    } catch (PDOException $exc) {
      require_once $this->config->getPath() . 'controller/FStudio/FStudio.class.php';
      $this->controller = new \FStudio($this->config);
      $this->controller->exception($exc);
      $this->renderView();
    }
  }

  /**
   * Carga los archivos base para la ejecución del sistema
   */
  protected function loadBasicFiles() {
    $files = array(
        'libs/vendor/FStudio/fsModel.class.php',
        'libs/vendor/FStudio/fsPlugin.class.php',
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
  protected function setRouting() {
    if (isset($_SERVER['PATH_INFO']) === true) {
      $data = explode('/', $_SERVER['PATH_INFO']);
      $this->module = isset($data[1]) === true ? $data[1] : null;
      $this->action = isset($data[2]) === true ? $data[2] : null;
      if ($this->module === null) {
        throw new PDOException('Escriba una dirección válida');
      }
      if ($this->action === null) {
        throw new PDOException('Escriba una dirección válida');
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
   * @throws PDOException
   */
  protected function loadAndExecutePlugins() {
    if (is_array($this->config->getPlugins()) === true and count($this->config->getPlugins()) > 0) {
      foreach ($this->config->getPlugins() as $pluginName) {
        $path = $this->config->getPath() . 'libs/plugins/' . $pluginName;
        if (is_dir($path) === false) {
          throw new PDOException('El plugin ' . $pluginName . ' no existe');
        }
        $file = $path . '/plugin.class.php';
        if (is_file($file) === false) {
          throw new PDOException('El archivo de inicio (plugin.php) no existe');
        }
        require_once $file;
        $pluginSpace = '\\' . $pluginName . '\\plugin';
        $plugin = new $pluginSpace($this->config);
      }
    }
  }

  /**
   * Carga el archivo referente al módulo y acción solicitado
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @throws PDOException
   */
  protected function loadModuleAndAction() {
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
      throw new PDOException('El módulo y acción solicitada, no existe');
    }
  }

  /**
   * Ejecuta el controlador solicitado
   */
  protected function executeController() {
    switch ($this->actionOractions) {
      case true:
        $this->controller = new $this->action($this->config);
        $this->controller->execute();
        break;
      case false;
        $this->controller = new $this->module($this->config);
        if (method_exists($this->controller, $this->action) === false) {
          throw new PDOException('La acción solicitadad no existe');
        }
        $this->controller->{$this->action}();
        break;
    }
  }

  /**
   * Renderiza la vista en el navegador
   */
  protected function renderView() {
    $this->view->setConfig($this->config);
    $this->view->setModule($this->controller->getViewModule());
    $this->view->setView($this->controller->getViewName());
    $this->view->setFormat($this->controller->getViewFormat());
    $this->view->assignVariables((array) $this->controller);
    $this->view->renderView();
  }

}
