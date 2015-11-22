<?php

use FStudio\model\base\usuarioCredencialBaseTable;

/**
 * Description of usuarioCredencialTable
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage model
 * @subpackage table
 * @version 1.0.0
 */
class usuarioCredencialTable extends usuarioCredencialBaseTable {

  public function getAll() {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, usuario_id, credencial_id, created_at FROM usuario_credencial ORDER BY created_at ASC';
    $answer = $conn->prepare($sql);
    $answer->execute();
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function getById($id) {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, usuario_id, credencial_id, created_at FROM usuario_credencial AND id = :id';
    $params = array(
        ':id' => $id
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function save() {
    $conn = $this->getConnection($this->config);
    $sql = 'INSERT INTO usuario_credencial (usuario_id, credencial_id) VALUES (:usuario_id, :credencial_id)';
    $params = array(
        ':usuario_id' => $this->getUsuarioId(),
        ':credencial_id' => $this->getCredencialId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return $conn->lastInsertId(self::_SEQUENCE);
  }

  public function update() {
    $conn = $this->getConnection($this->config);
    $sql = 'UPDATE usuario_credencial SET usuario_id = :usuario_id, credencial_id = :credencial_id WHERE id = :id';
    $params = array(
        ':usuario_id' => $this->getUsuarioId(),
        ':credencial_id' => $this->getCredencialId(),
        ':id' => $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

  public function delete() {
    $conn = $this->getConnection($this->config);
    $sql = 'DELETE FROM usuario_credencial WHERE id = :id';
    $params = array(
        ':id' => $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

}
