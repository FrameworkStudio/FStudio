<?php

namespace FStudio;

use PDOException;

/**
 * Versión actual de la línea base (Framework Studio)
 */
define('FS_VERSION', '1.0.2');

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
  protected $alternateController;

  /**
   * Camino a disponer para la acción o controlador a ejecutar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  protected $path;

  /**
   * Identifica (1 o 2) si ejecuta un controlador para una acción<br>
   * o (3 o 4) si ejecuta un controlador con muchas acciones
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var integer
   */
  protected $actionOrActions;

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
  const ACTIONS1 = '%path%%module%/%module%Controller.class.php';

  /**
   * Plantilla para cargar un controlador con muchas acciones
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   */
  const ACTIONS2 = '%path%%module%/%module%.class.php';

  /**
   * Plantilla para cargar un controlador con muchas acciones
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   */
  const ACTIONS3 = '%path%%alternateController%Controller.class.php';

  /**
   * Plantilla para cargar un controlador con muchas acciones
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   */
  const ACTIONS4 = '%path%%alternateController%.class.php';

  /**
   * Plantilla para cargar el controlador de una acción
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   */
  const ACTION1 = '%path%%module%/%action%Action.class.php';

  /**
   * Plantilla para cargar el controlador de una acción
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   */
  const ACTION2 = '%path%%module%/%action%.class.php';

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
      require_once $this->config->getPath() . 'controller/FStudio/FStudioController.class.php';
      $this->controller = new \FStudioController($this->config);
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
    $this->path = $this->config->getPath() . 'controller/';
    if (isset($_SERVER['PATH_INFO']) === true) {
      $data = explode('/', $_SERVER['PATH_INFO']);
      $cnt = count($data);
      switch ($cnt) {
        case 3:
          $this->module = $data[1];
          $this->action = $data[2];
          break;
        default:
          if ($cnt > 3) {
            $this->module = $data[$cnt - 2];
            $this->action = $data[$cnt - 1];
            unset($data[$cnt - 2], $data[$cnt - 1]);
            $cnt = count($data);
            for ($x = 1; $x < $cnt; $x++) {
              $this->path .= $data[$x] . '/';
            }
            $this->alternateController = $this->module;
          } else {
            throw new PDOException('La dirección solicitada no existe en el sistema');
          }
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
    $action1 = strtr(self::ACTION1, array(
        '%path%' => $this->path,
        '%module%' => $this->module,
        '%action%' => $this->action,
    ));
    $action2 = strtr(self::ACTION2, array(
        '%path%' => $this->path,
        '%module%' => $this->module,
        '%action%' => $this->action,
    ));
    $actions1 = strtr(self::ACTIONS1, array(
        '%path%' => $this->path,
        '%module%' => $this->module,
    ));
    $actions2 = strtr(self::ACTIONS2, array(
        '%path%' => $this->path,
        '%module%' => $this->module,
    ));
    if (empty($this->alternateController) === false) {
      $actions3 = strtr(self::ACTIONS3, array(
          '%path%' => $this->path,
          '%alternateController%' => $this->alternateController,
      ));
      $actions4 = strtr(self::ACTIONS4, array(
          '%path%' => $this->path,
          '%alternateController%' => $this->alternateController,
      ));
    } else {
      $actions3 = $actions4 = null;
    }
    if (file_exists($action1) === true) {
      require_once $action1;
      $this->actionOrActions = 1;
    } elseif (file_exists($action2) === true) {
      require_once $action2;
      $this->actionOrActions = 2;
    } else if (file_exists($actions1)) {
      require_once $actions1;
      $this->actionOrActions = 3;
    } else if (file_exists($actions2)) {
      require_once $actions2;
      $this->actionOrActions = 4;
    } else if (file_exists($actions3)) {
      require_once $actions3;
      $this->actionOrActions = 5;
    } else if (file_exists($actions4)) {
      require_once $actions4;
      $this->actionOrActions = 6;
    } else {
      throw new PDOException('El módulo y acción solicitada, no existe');
    }
  }

  /**
   * Ejecuta el controlador solicitado
   */
  protected function executeController() {
    switch ($this->actionOrActions) {
      case 1:
        $action = $this->action . 'Action';
        $this->controller = new $action($this->config);
        $this->controller->execute();
        break;
      case 2:
        $this->controller = new $this->action($this->config);
        $this->controller->execute();
        break;
      case 3:
        $module = $this->module . 'Controller';
        $this->controller = new $module($this->config);
        if (method_exists($this->controller, $this->action) === false) {
          throw new PDOException('La acción solicitadad no existe');
        }
        $this->controller->{$this->action}();
        break;
      case 4;
        $this->controller = new $this->module($this->config);
        if (method_exists($this->controller, $this->action) === false) {
          throw new PDOException('La acción solicitadad no existe');
        }
        $this->controller->{$this->action}();
        break;
      case 5:
        $module = $this->alternateController . 'Controller';
        $this->controller = new $module($this->config);
        if (method_exists($this->controller, $this->action) === false) {
          throw new PDOException('La acción solicitadad no existe');
        }
        $this->controller->{$this->action}();
        break;
      case 6;
        $this->controller = new $this->alternateController($this->config);
        if (method_exists($this->controller, $this->action) === false) {
          throw new PDOException('La acción solicitadad no existe');
        }
        $this->controller->{$this->action}();
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
