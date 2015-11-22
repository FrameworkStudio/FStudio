<?php

namespace FStudio;

/**
 * Clase base para los controladores el sistema
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @version 1.0.0
 * @package FStudio
 * @subpackage controller
 */
class fsController {

  /**
   * Configuración del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var myConfig
   */
  private $config;

  /**
   * Nombre del módulo de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $viewModule;

  /**
   * Nombre de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $viewName;

  /**
   * Formato de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @var string
   */
  private $viewFormat;

  /**
   * Contructor de la clase fsController
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param \FStudio\myConfig $config Objeto de la configuración del sistema
   */
  public function __construct(myConfig $config) {
    $this->config = $config;
    $this->fsConfig = $config;
  }

  /**
   * Retorna la configuración del sistema
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return myConfig
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * 
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @param string $module Módulo de la vista
   * @param string $view Nombre de la vista
   * @param strign $format Formato de la vista (html, pdf, json, etc)
   */
  public function defineView($module, $view, $format) {
    $this->viewModule = $module;
    $this->viewName = $view;
    $this->viewFormat = $format;
  }

  /**
   * Retorna el módulo de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string Módulo de la vista
   */
  public function getViewModule() {
    return $this->viewModule;
  }

  /**
   * Obtiene el nombre de la vista
   * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
   * @version 1.0.0
   * @return string Nombre de la vista
   */
  public function getViewName() {
    return $this->viewName;
  }

  /**
   * Obtiene el formato de la vista<br>
   * Ejemplo: html, pdf, json, entre otros
   * @return type Formato de la vista
   */
  public function getViewFormat() {
    return $this->viewFormat;
  }

}
