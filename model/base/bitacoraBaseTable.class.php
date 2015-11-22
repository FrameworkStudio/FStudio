<?php

namespace FStudio\model\base;

use FStudio\fsModel as model;
use FStudio\myConfig as config;

/**
 * Description of bitacoraBaseTable
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage model
 * @subpackage base
 * @version 1.0.0
 */
class bitacoraBaseTable extends model {

  const ID = 'id';
  const ACCION = 'accion';
  const ACCION_LENGTH = 80;
  const USUARIO_ID = 'usuario_id';
  const OBSERVACION = 'observacion';
  const OBSERVACION_LENGTH = 1024;
  const TABLA = 'tabla';
  const TABLA_LENGTH = 80;
  const REGISTRO = 'registro';
  const CREATED_AT = 'created_at';
  const _SEQUENCE = 'bitacora_id_seq';
  const _TABLE = 'bitacora';

  /**
   * Configuración del sistema
   * @var config
   */
  protected $config;
  private $id;
  private $accion;
  private $usuario_id;
  private $observacion;
  private $tabla;
  private $registro;
  private $created_at;

  public function __construct(config $config, $id = null, $accion = null, $usuario_id = null, $observacion = null, $tabla = null, $registro = null, $created_at = null) {
    $this->config = $config;
    $this->id = $id;
    $this->accion = $accion;
    $this->usuario_id = $usuario_id;
    $this->observacion = $observacion;
    $this->tabla = $tabla;
    $this->registro = $registro;
    $this->created_at = $created_at;
  }

  public function getId() {
    return $this->id;
  }

  public function getAccion() {
    return $this->accion;
  }

  public function getUsuarioId() {
    return $this->usuario_id;
  }

  public function getObservacion() {
    return $this->observacion;
  }

  public function getTabla() {
    return $this->tabla;
  }

  public function getRegistro() {
    return $this->registro;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function setAccion($accion) {
    $this->accion = $accion;
  }

  public function setUsuarioId($usuario_id) {
    $this->usuario_id = $usuario_id;
  }

  public function setObservacion($observacion) {
    $this->observacion = $observacion;
  }

  public function setTabla($tabla) {
    $this->tabla = $tabla;
  }

  public function setRegistro($registro) {
    $this->registro = $registro;
  }

  public function setCreatedAt($created_at) {
    $this->created_at = $created_at;
  }

}
