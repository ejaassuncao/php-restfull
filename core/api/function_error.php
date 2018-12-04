<?php

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:function_error
 */

function hb_error_handler($severity, $message, $filepath, $line) {

   header("HTTP/1.0 500  Internal Server Error");
   header("Content-Type: text/html;charset=UTF-8");
   echo "<div class=\"row\" style=\"margin-top:10px\"><div class=\"col-md-8 col-md-offset-2\"><div class=\"alert alert-danger\" role=\"alert\"><p><string>Mensagem: </strong>{$message}<br/>";
   echo "<string>Arquivo: </strong>{$filepath}<br/>";
   echo "<string>Linha: </strong>{$line}<br/>";
   echo "<string>severity: </strong>{$severity}<br/>";
   echo "</p></div></div></div>";
  
   exit(1); // EXIT_ERROR
}


function hb_shutdown_handler() {
   $last_error = error_get_last();
   if (isset($last_error) &&
           ($last_error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING))) {
      hb_error_handler($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
   }
}
function hb_exception_handler($exception) {
   $last_error = error_get_last();
   hb_error_handler($last_error['type'], $exception->getMessage(), $exception->getFile(), $exception->getLine());
   exit(1); // EXIT_ERROR
}
$level =  null;
if ($level == null) {
   if (defined("E_DEPRECATED")) {
      $level = E_ALL & ~E_DEPRECATED;
   } else {
      // php 5.2 and earlier don't support E_DEPRECATED
      $level = E_ALL;
      self::$IGNORE_DEPRECATED = true;
   }
}
set_error_handler("hb_error_handler", $level);
set_exception_handler("hb_exception_handler");
register_shutdown_function('hb_shutdown_handler');

