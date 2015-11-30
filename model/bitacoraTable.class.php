<?php

use FStudio\model\base\bitacoraBaseTable;

/**
 * Description of bitacoraTable
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage model
 * @subpackage table
 * @version 1.0.0
 */
class bitacoraTable extends bitacoraBaseTable {

  public function getAll() {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, accion, usuario_id, observacion, tabla, registro, created_at FROM bitacora ORDER BY created_at ASC';
    $answer = $conn->prepare($sql);
    $answer->execute();
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function getById($id = null) {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, accion, usuario_id, observacion, tabla, registro, created_at FROM bitacora AND id = :id';
    $params = array(
        ':id' => ($id !== null) ? $id : $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function save() {
    $conn = $this->getConnection($this->config);
    $sql = 'INSERT INTO bitacora (accion, usuario_id, observacion, tabla, registro) VALUES (:accion, :usuario_id, :observacion, :tabla, :registro)';
    $params = array(
        ':accion' => $this->getAccion(),
        ':usuario_id' => $this->getUsuarioId(),
        ':observacion' => $this->getObservacion(),
        ':tabla' => $this->getTabla(),
        ':registro' => $this->getRegistro()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    $this->setId($conn->lastInsertId(self::_SEQUENCE)); // postgresql
    // $this->setId($conn->lastInsertId()); // mysql
    return true;
  }

  public function update() {
    $conn = $this->getConnection($this->config);
    $sql = 'UPDATE bitacora SET accion = :accion, usuario_id = :usuario_id, observacion = :observacion, tabla = :tabla, registro = :registro WHERE id = :id';
    $params = array(
        ':accion' => $this->getAccion(),
        ':usuario_id' => $this->getUsuarioId(),
        ':observacion' => $this->getObservacion(),
        ':tabla' => $this->getTabla(),
        ':registro' => $this->getRegistro(),
        ':id' => $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

  public function delete() {
    $conn = $this->getConnection($this->config);
    $sql = 'DELETE FROM bitacora WHERE id = :id';
    $params = array(
        ':id' => $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

}
