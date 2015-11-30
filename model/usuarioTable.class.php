<?php

use FStudio\model\base\usuarioBaseTable;

/**
 * Description of usuarioTable
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage model
 * @subpackage table
 * @version 1.0.0
 */
class usuarioTable extends usuarioBaseTable {

  public function getAll() {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, user_name, password, actived, last_login_at, created_at, updated_at, deleted_at FROM usuario WHERE deleted_at IS NULL ORDER BY created_at ASC';
    $answer = $conn->prepare($sql);
    $answer->execute();
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function getById($id = null) {
    $conn = $this->getConnection($this->config);
    $sql = 'SELECT id, user_name, password, actived, last_login_at, created_at, updated_at, deleted_at FROM usuario WHERE deleted_at IS NULL AND id = :id';
    $params = array(
        ':id' => ($id !== null) ? $id : $this->getId()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return ($answer->rowCount() > 0) ? $answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function save() {
    $conn = $this->getConnection($this->config);
    $sql = 'INSERT INTO usuario (user_name, password, actived, last_login_at) VALUES (:user_name, :password, :actived, :last_login_at)';
    $params = array(
        ':user_name' => $this->getUserName(),
        ':password' => $this->getPassword(),
        ':actived' => $this->getActived(),
        ':last_login_at' => $this->getLastLoginAt()
    );
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    $this->setId($conn->lastInsertId(self::_SEQUENCE)); // postgresql
    // $this->setId($conn->lastInsertId()); // mysql
    return true;
  }

  public function update() {
    $conn = $this->getConnection($this->config);
    $sql = 'UPDATE usuario SET user_name = :user_name, password = :password, actived = :actived, last_login_at = :last_login_at WHERE id = :id';
    $params = array(
        ':user_name' => $this->getUserName(),
        ':password' => $this->getPassword(),
        ':actived' => $this->getActived(),
        ':last_login_at' => $this->getLastLoginAt(),
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
        $sql = 'UPDATE usuario SET deleted_at = now() WHERE id = :id';
        break;
      case false:
        $sql = 'DELETE FROM usuario WHERE id = :id';
        break;
      default:
        throw new PDOException('Por favor indique un dato coherente para el borrado lógico (true) o físico (false)');
    }
    $answer = $conn->prepare($sql);
    $answer->execute($params);
    return true;
  }

}
