<?php

use FStudio\model\base\recordarMeBaseTable;

/**
 * Description of recordarMeTable
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage model
 * @subpackage table
 * @version 1.0.0
 */
class recordarMeTable extends recordarMeBaseTable {

  public function getAll() {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, ip_address, hash_cookie, usuario_id, created_at FROM recordar_me ORDER BY created_at ASC';
    $answer = $conn->prepare($sql);
    $answer->execute();
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function getById($id = null) {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, ip_address, hash_cookie, usuario_id, created_at FROM recordar_me AND id = :id';
    $params = array(
        ':id' => ($id !== null) ? $id : $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function save() {
    $conn = $this->getConnection($this->config);
    $sql = 'INSERT INTO recordar_me (ip_address, hash_cookie, usuario_id) VALUES (:ip_address, :hash_cookie, :usuario_id)';
    $params = array(
        ':ip_address' => $this->getIpAddress(),
        ':hash_cookie' => $this->getHashCookie(),
        ':usuario_id' => $this->getUsuarioId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    $this->setId($conn->lastInsertId(self::_SEQUENCE)); // postgresql
    // $this->setId($conn->lastInsertId()); // mysql
    return true;
  }

  public function update() {
    $conn = $this->getConnection($this->config);
    $sql = 'UPDATE recordar_me SET ip_address = :ip_address, hash_cookie = :hash_cookie, usuario_id = :usuario_id WHERE id = :id';
    $params = array(
        ':ip_address' => $this->getIpAddress(),
        ':hash_cookie' => $this->getHashCookie(),
        ':usuario_id' => $this->getUsuarioId(),
        ':id' => $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

  public function delete() {
    $conn = $this->getConnection($this->config);
    $sql = 'DELETE FROM recordar_me WHERE id = :id';
    $params = array(
        ':id' => $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

}
