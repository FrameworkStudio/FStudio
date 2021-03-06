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

use FStudio\fsController as controller;
use FStudio\interfaces\fsAction as action;

/**
 * Description of wellcome
 *
 * @author Julian Lasso <ingeniero.julianlasso@gmail.com>
 * @package FStudio
 * @subpackage controller
 * @subpackage wellcome
 * @version 1.0.0
 */
class wellcome extends controller implements action {

  public function execute() {
    $this->mensaje = "Wellcome to FrameWork Studio Alternativo Action 7";
    $this->defineView('FStudio', 'wellcome', 'html');
  }

}
