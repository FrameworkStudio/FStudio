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

// php fstudio modulo:accion "Julian Lasso" ingeniero.julianlasso@gmail.com modulo:prueba accion:index

use fsCamelCasePlugin\fsCamelCase as camcelCase;

try {
  $cc = new camcelCase();
  $autor = $argv[2];
  $email = $argv[3];
  $module = $cc->camelCase(explode(':', $argv[4])[1]);
  $action = $cc->camelCase(explode(':', $argv[5])[1]);
  $year = date("Y");

  $dir = $config->getPath() . 'controller/' . $module;
  $file = $dir . '/' . $action . '.class.php';

  if (is_file($file) === true) {
    throw new Exception(
    "\n+--------------------------------------------------------+\n"
    . "| ERROR!!!                                               |\n"
    . "+--------------------------------------------------------+\n"
    . "| La acción que deseas crear ya está creada              |\n"
    . "+--------------------------------------------------------+\n"
    . "\n\n"
    );
  } elseif (is_dir($dir) === false) {
    mkdir($dir);
  }

  $template = <<<TEMPLATE
<?php
/* 
 * Copyright $year $autor <$email>.
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

use FStudio\\fsController as controller;
use FStudio\\interfaces\\fsAction as action;

/**
 * Description of $action
 * 
 * @author $autor <$email>
 * @package FStudio
 * @subpackage controller
 * @subpackage $action
 * @version 1.0.0
 */
class $action extends controller implements action {

    public function execute() {
      //put your code here
      \$this->defineView(\$modulo, \$vista, 'html');
    }
}

TEMPLATE;

  $file = fopen($file, "w");
  fwrite($file, $template);
  fclose($file);
} catch (Exception $exc) {
  throw $exc;
}
