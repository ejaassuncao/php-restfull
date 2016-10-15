<?php

function __autoload($class) {
   $class = str_replace("\\", DIRECTORY_SEPARATOR, BASE_PATH . $class . '.php');
   if (!file_exists($class)) {
      core\helper\HB_Error_Helper::Erro_404("file path '{$class}' not found.");
   }
   require_once ($class);
}
