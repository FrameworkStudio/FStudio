<?php

/* 
 * Copyright 2015 Julian Lasso <ingeniero.julianlasso@gmail.com>.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// php fstudio modelo:generar

use fsCamelCasePlugin\fsCamelCase as camelCase;
use Symfony\Component\Yaml\Parser;

if (is_file('config/model.yml') === false) { 
  throw new Exception("El archivo model.yml no existe en la carpeta config/\n");
}

$yaml = new Parser();
$cc = new camelCase();
$model = $yaml->parse(file_get_contents('config/model.yml'));

if (is_dir('model') === false) {
  mkdir('model');
}

if (is_dir('model/base') === false) {
  mkdir('model/base');
}

foreach ($model['schema'] as $table => $attributes) {
  $nameTable = "  const _TABLE = '$table';\n";
  $tableClass = (isset($attributes['name']) === true) ? $attributes['name'] : $table;
  $nameFileBase = $cc->camelCase($tableClass . 'BaseTable');
  $nameFileTable = $cc->camelCase($tableClass . 'Table');
  $constructHead = "\n  public function __construct(config \$config, ";
  $constructHeadItems = '';
  $constructBody = "    \$this->config = \$config;\n";
  $fieldsAll = '';
  $deleted_at = '';
  $created_at = '';
  $saveFields = '';
  $saveValues = '';
  $saveParams = '';
  $setUpdate = '';
  $setUpdateID = '';
  $updateParams = '';
  $deleteUpdate = '';
  $deleteTemplate = '';
  $fileTable = <<<TABLE
<?php

use FStudio\\model\\base\\$nameFileBase;

/**
 * Description of $nameFileTable
 *
 * @author nombre completo <su@correo.com>
 * @package FStudio
 * @subpackage model
 * @subpackage table
 * @version 1.0.0
 */
class $nameFileTable extends $nameFileBase {

  public function getAll() {
    \$conn = \$this->getConnection(\$this->config);
    \$sql = 'SELECT %fieldsAll% FROM $table %deleted_at%ORDER BY %created_at% ASC';
    \$answer = \$conn->prepare(\$sql);
    \$answer->execute();
    return (\$answer->rowCount() > 0) ? \$answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function getById(\$id = null) {
    \$conn = \$this->getConnection(\$this->config);
    \$sql = 'SELECT %fieldsAll% FROM $table %deleted_at%AND id = :id';
    \$params = array(
        ':id' => (\$id !== null) ? \$id : \$this->%getId%()
    );
    \$answer = \$conn->prepare(\$sql);
    \$answer->execute(\$params);
    return (\$answer->rowCount() > 0) ? \$answer->fetchAll(PDO::FETCH_OBJ) : false;
  }

  public function save() {
    \$conn = \$this->getConnection(\$this->config);
    \$sql = 'INSERT INTO $table (%saveFields%) VALUES (%saveValues%)';
    \$params = array(
%saveParams%
    );
    \$answer = \$conn->prepare(\$sql);
    \$answer->execute(\$params);
    \$this->%setId%(\$conn->lastInsertId(self::_SEQUENCE));
    return true;
  }

  public function update() {
    \$conn = \$this->getConnection(\$this->config);
    \$sql = 'UPDATE $table SET %setUpdate% WHERE %setUpdateID%';
    \$params = array(
%updateParams%
    );
    \$answer = \$conn->prepare(\$sql);
    \$answer->execute(\$params);
    return true;
  }

%deleteTemplate%

}\n
TABLE;
  $fileBase = <<<BASE
<?php

namespace FStudio\\model\\base;

use FStudio\\fsModel as model;
use FStudio\\myConfig as config;

/**
 * Description of $nameFileBase
 *
 * @author nombre completo <su@correo.com>
 * @package FStudio
 * @subpackage model
 * @subpackage base
 * @version 1.0.0
 */
class $nameFileBase extends model {\n

BASE;
  $const = '';
  $attr = '';
  $sequence = '';
  $get = '';
  $set = '';
  $setId = '';
  $getId = '';
  foreach ($attributes as $item => $attribute) {
    if ($item === 'columns') {
      foreach ($attribute as $nameAttribute => $content) {
        $nameAttributeShort = (isset($content['name']) === true) ? $content['name'] : $nameAttribute;
        $nameAttributeOriginal = $nameAttribute;
        $fieldsAll .= ($nameAttributeOriginal === $nameAttributeShort) ? "$nameAttributeOriginal, " : "$nameAttributeOriginal AS $nameAttributeShort, ";
        $upper = strtoupper($nameAttributeShort);
        $getFunction = $cc->camelCase('get_' . $nameAttributeShort);
        $setFunction = $cc->camelCase('set_' . $nameAttributeShort);
        $attr .= "  private \$$nameAttributeShort;\n";
        $const .= "  const $upper = '$nameAttributeOriginal';\n";
        $get .= "\n  public function $getFunction() {\n    return \$this->$nameAttributeShort;\n  }\n";
        $set .= "\n  public function $setFunction(\$$nameAttributeShort) {\n    \$this->$nameAttributeShort = \$$nameAttributeShort;\n  }\n";
        $constructHeadItems .= "\$$nameAttributeShort = ";
        $constructBody .= "    \$this->$nameAttributeShort = \$$nameAttributeShort;\n";
        if (isset($content['behavior']) and $content['behavior'] === 'deleted') {
          $deleted_at = "WHERE $nameAttributeOriginal IS NULL ";
          $deleteUpdate = "$nameAttributeOriginal = now()";
          $deleteTemplate = <<<DELETE
  public function delete(\$deleteLogical = true) {
    \$conn = \$this->getConnection(\$this->config);
    \$params = array(
%deleteID%
    );
    switch (\$deleteLogical) {
      case true:
        \$sql = 'UPDATE $table SET %deleteUpdate% WHERE %setUpdateID%';
        break;
      case false:
        \$sql = 'DELETE FROM $table WHERE %setUpdateID%';
        break;
      default:
        throw new PDOException('Por favor indique un dato coherente para el borrado lógico (true) o físico (false)');
    }
    \$answer = \$conn->prepare(\$sql);
    \$answer->execute(\$params);
    return true;
  }
DELETE;
        } else if (isset($content['behavior']) and $content['behavior'] === 'created') {
          $created_at = $nameAttributeOriginal;
        } else if (isset($content['constraint']) and $content['constraint'] === 'PK') {
          $setUpdateID = "$nameAttributeOriginal = :$nameAttributeShort";
          $updateParams = "        ':$nameAttributeShort' => \$this->$getFunction()";
          $setId = $setFunction;
          $getId = $getFunction;
        } else if (isset($content['constraint']) === false and isset($content['behavior']) === false) {
          $saveFields .= $nameAttributeOriginal . ', ';
          $saveValues .= ':' . $nameAttributeShort . ', ';
          $saveParams .= "        ':$nameAttributeShort' => \$this->$getFunction(),\n";
          $setUpdate .= "$nameAttributeOriginal = :$nameAttributeShort, ";
        }

        if (isset($content['behavior']) and $content['behavior'] !== 'deleted') {
          $deleteTemplate = <<<DELETE
  public function delete() {
    \$conn = \$this->getConnection(\$this->config);
    \$sql = 'DELETE FROM $table WHERE %setUpdateID%';
    \$params = array(
%deleteID%
    );
    \$answer = \$conn->prepare(\$sql);
    \$answer->execute(\$params);
    return true;
  }
DELETE;
        }
        foreach ($content as $key => $value) {
          $flagDefault = true;
          switch ($key) {
            case 'length':
              $const .= "  const " . $upper . "_LENGTH = $value;\n";
              break;
            case 'sequence':
              $sequence = "  const _SEQUENCE = '$value';\n";
              break;
            case 'encrypted':
              $set = str_replace(
                      "\n  public function $setFunction(\$$nameAttributeShort) {\n    \$this->$nameAttributeShort = \$$nameAttributeShort;\n  }\n", "\n  public function $setFunction(\$$nameAttributeShort) {\n    \$this->$nameAttributeShort = hash('$value', \$$nameAttributeShort);\n  }\n", $set);
              break;
            case 'default':
              $flagDefault = false;
              if ($value === true) {
                $constructHeadItems .= "true, ";
              } else if ($value === false) {
                $constructHeadItems .= "false, ";
              } else if (is_numeric($value) === true) {
                $constructHeadItems .= "$value, ";
              } else if (is_array($value) === true) {
                $constructHeadItems .= "null, ";
                if ($value['value'] === 'NOW') {
                  $constructBody = substr($constructBody, 0, ((strlen($nameAttributeShort) * -1) + -3));
                  $constructBody .= "(\$$nameAttributeShort === null) ? date('" . $value['format'] . "') : \$$nameAttributeShort;\n";
                }
              } else {
                $constructHeadItems .= "'$value', ";
              }
              break;
          }
          # echo "$table -> $nameAttribute -> $key -> $value\n";
        }
        if ($flagDefault) {
          $constructHeadItems .= "null, ";
        }
      }
    }
  }
  $configTemplate = "  /**\n   * Configuración del sistema\n   * @var config\n   */\n  protected \$config;\n";
  $constructHeadItems = substr($constructHeadItems, 0, -2);
  $constructBody = substr($constructBody, 0, -1);
  $construct = $constructHead . $constructHeadItems . ") {\n" . $constructBody . "\n  }\n";
  $fileBase .= $const . $sequence . $nameTable . "\n" . $configTemplate . $attr . $construct . $get . $set . "\n}\n";

  # echo $base;
  $file = fopen($config->getPath() . "model/base/$nameFileBase.class.php", "w");
  fwrite($file, $fileBase);
  fclose($file);

  $file = $config->getPath() . "model/$nameFileTable.class.php";
  $fileTable = strtr($fileTable, array(
      '%fieldsAll%' => substr($fieldsAll, 0, -2),
      '%deleted_at%' => $deleted_at,
      '%created_at%' => $created_at,
      '%saveFields%' => substr($saveFields, 0, -2),
      '%saveValues%' => substr($saveValues, 0, -2),
      '%saveParams%' => substr($saveParams, 0, -2),
      '%setId%' => $setId,
      '%getId%' => $getId,
      '%setUpdate%' => substr($setUpdate, 0, -2),
      '%setUpdateID%' => $setUpdateID,
      '%updateParams%' => $saveParams . $updateParams,
      '%deleteID%' => $updateParams,
      '%deleteUpdate%' => $deleteUpdate,
      '%deleteTemplate%' => strtr($deleteTemplate, array(
          '%setUpdateID%' => $setUpdateID,
          '%deleteID%' => $updateParams,
          '%deleteUpdate%' => $deleteUpdate
      ))
  ));

  if (file_exists($file) === false) {
    $file = fopen($file, "w");
    fwrite($file, $fileTable);
    fclose($file);
  }
}