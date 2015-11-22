<?php

namespace FStudio;

/**
 * Clase para manejar las vistas del sistema
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @version 1.0.0
 * @package FStudio
 * @subpackage view
 */
class fsView {

  /**
   * Configuración del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var myConfig
   */
  protected $config;

  /**
   * Variables que pasarán a la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var array
   */
  private $variables;

  /**
   * Módulo de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var strign
   */
  private $module;

  /**
   * Nombre de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $view;

  /**
   * Formato de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $format;

  /**
   * Constructor de la clase view
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param \FStudio\myConfig $config
   * @param string $module
   * @param string $view
   * @param string $format
   */
  public function __construct(myConfig $config, $module, $view, $format) {
    $this->config = $config;
    $this->module = $module;
    $this->view = $view;
    $this->format = $format;
  }

  /**
   * Asignación de variables a la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param array $varaiables
   */
  public function assignVariables(array $varaiables) {
    $this->variables = $varaiables;
  }

  /**
   * Renderiza la vista en el navegador del cliente
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   */
  public function renderView() {
    if (is_array($this->variables) === true and count($this->variables) > 0) {
      extract($this->variables);
    }
    if (file_exists($this->getFileView()) === false) {
      throw new \PDOException('La vista solicitada no existe');
    }
    require_once $this->getFileView();
  }

  /**
   * Obtiene la dirección completa del archivo de la vista a cargar
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string
   */
  private function getFileView() {
    return $this->config->getPath() . 'view/' . $this->module . '/' . $this->view . '.' . $this->format . '.php';
  }

}
