<?php

use FStudio\model\base\credencialBaseTable;

/**
 * Description of credencialTable
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage model
 * @subpackage table
 * @version 1.0.0
 */
class credencialTable extends credencialBaseTable {

  public function getAll() {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, nombre, usuario_id, created_at, updated_at, deleted_at FROM credencial WHERE deleted_at IS NULL ORDER BY created_at ASC';
    $answer = $conn->prepare($sql);
    $answer->execute();
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function getById($id = null) {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, nombre, usuario_id, created_at, updated_at, deleted_at FROM credencial WHERE deleted_at IS NULL AND id = :id';
    $params = array(
        ':id' => ($id !== null) ? $id : $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function save() {
    $conn = $this->getConnection($this->config);
    $sql = 'INSERT INTO credencial (nombre, usuario_id) VALUES (:nombre, :usuario_id)';
    $params = array(
        ':nombre' => $this->getNombre(),
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
    $sql = 'UPDATE credencial SET nombre = :nombre, usuario_id = :usuario_id WHERE id = :id';
    $params = array(
        ':nombre' => $this->getNombre(),
        ':usuario_id' => $this->getUsuarioId(),
        ':id' => $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

  public function delete($deleteLogical = true) {
    $conn = $this->getConnection($this->config);
    $params = array(
        ':id' => $this->getId()
    );
    switch ($deleteLogical) {
      case true:
        $sql = 'UPDATE credencial SET deleted_at = now() WHERE id = :id';
        break;
      case false:
        $sql = 'DELETE FROM credencial WHERE id = :id';
        break;
      default:
        throw new PDOException('Por favor indique un dato coherente para el borrado lógico (true) o físico (false)');
    }
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

}
