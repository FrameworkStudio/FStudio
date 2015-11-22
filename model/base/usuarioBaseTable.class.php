<?php

namespace FStudio\model\base;

use FStudio\fsModel as model;
use FStudio\myConfig as config;

/**
 * Description of usuarioBaseTable
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage model
 * @subpackage base
 * @version 1.0.0
 */
class usuarioBaseTable extends model {

  const ID = 'id';
  const USER_NAME = 'user_name';
  const USER_NAME_LENGTH = 80;
  const PASSWORD = 'password';
  const PASSWORD_LENGTH = 32;
  const ACTIVED = 'actived';
  const LAST_LOGIN_AT = 'last_login_at';
  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';
  const DELETED_AT = 'deleted_at';
  const _SEQUENCE = 'usuario_id_seq';
  const _TABLE = 'usuario';

  /**
   * Configuración del sistema
   * @var config
   */
  protected $config;
  private $id;
  private $user_name;
  private $password;
  private $actived;
  private $last_login_at;
  private $created_at;
  private $updated_at;
  private $deleted_at;

  public function __construct(config $config, $id = null, $user_name = null, $password = null, $actived = 't', $last_login_at = null, $created_at = null, $updated_at = null, $deleted_at = null) {
    $this->config = $config;
    $this->id = $id;
    $this->user_name = $user_name;
    $this->password = $password;
    $this->actived = $actived;
    $this->last_login_at = ($last_login_at === null) ? date('Y-m-d H:i:s') : $last_login_at;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->deleted_at = $deleted_at;
  }

  public function getId() {
    return $this->id;
  }

  public function getUserName() {
    return $this->user_name;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getActived() {
    return $this->actived;
  }

  public function getLastLoginAt() {
    return $this->last_login_at;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function getUpdatedAt() {
    return $this->updated_at;
  }

  public function getDeletedAt() {
    return $this->deleted_at;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function setUserName($user_name) {
    $this->user_name = $user_name;
  }

  public function setPassword($password) {
    $this->password = hash('md5', $password);
  }

  public function setActived($actived) {
    $this->actived = $actived;
  }

  public function setLastLoginAt($last_login_at) {
    $this->last_login_at = $last_login_at;
  }

  public function setCreatedAt($created_at) {
    $this->created_at = $created_at;
  }

  public function setUpdatedAt($updated_at) {
    $this->updated_at = $updated_at;
  }

  public function setDeletedAt($deleted_at) {
    $this->deleted_at = $deleted_at;
  }

}
