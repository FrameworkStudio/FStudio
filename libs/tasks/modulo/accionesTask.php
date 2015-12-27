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

// php fstudio modulo:acciones "Julian Lasso" ingeniero.julianlasso@gmail.com module:prueba controller:prueba

use fsCamelCasePlugin\fsCamelCase as camcelCase;

try {
  $cc = new camcelCase();
  $autor = $argv[2];
  $email = $argv[3];
  $module = $cc->camelCase(explode(':', $argv[4])[1]);
  $moduleName = $cc->camelCase(explode(':', $argv[((isset($argv[5]) === true) ? 5 : 4)])[1]) . 'Controller';
  $year = date("Y");

  $dir = $config->getPath() . 'controller/' . $module;
  $file = $dir . '/' . $moduleName . '.class.php';

  if (is_file($file) === true) {
    throw new Exception(
    "\n+--------------------------------------------------------+\n"
    . "| ERROR!!!                                               |\n"
    . "+--------------------------------------------------------+\n"
    . "| El modulo y acción que deseas crear ya está creada     |\n"
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

/**
 * Description of $moduleName
 * 
 * @author $year $autor <$email>
 * @package FStudio
 * @subpackage controller
 * @subpackage $module
 * @version 1.0.0
 */
class $moduleName extends controller {

  public function index() {
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
