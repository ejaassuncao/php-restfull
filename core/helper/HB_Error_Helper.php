<?php

namespace core\helper;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description: Classe de Helper para Retornar erros do server.
 */
class HB_Error_Helper {

   private static $statusCode;
   private static $message;
   private static $describle;

   private static function execute() {
      $header = "HTTP/1.0 " . self::$statusCode . " " . self::$message;
      $object = array(array("status_code" => self::$statusCode, "header" => $header, "message" => self::$describle));

      header('Content-Type: application/json;charset=utf-8');
      header('Content-Type: text/html; charset=utf-8');
      header('Content-Type: text/xml; charset=utf-8');
      header($header);
      die(json_encode($object));
   }

   public static function Erro_400($msg = null) {
      self::$statusCode = 400;
      self::$message = "Bad Request";
      self::$describle = $msg;
      self::execute();
   }

   public static function Erro_401($msg = null) {
      self::$statusCode = 401;
      self::$message = "Unauthorized";
      self::$describle = $msg;
      self::execute();
   }

   public static function Erro_403($msg = null) {
      self::$statusCode = 403;
      self::$message = "Forbidden";
      self::$describle = $msg;
      self::execute();
   }

   public static function Erro_404($msg = null) {
      self::$statusCode = 404;
      self::$message = "Not Found";
      self::$describle = $msg;
      self::execute();
   }

   public static function Erro_405($msg = null) {
      self::$statusCode = 405;
      self::$message = "Method Not Allowed";
      self::$describle = $msg;
      self::execute();
   }

   public static function Erro_406($msg = null) {
      self::$statusCode = 406;
      self::$message = "Not Acceptable";
      self::$describle = $msg;
      self::execute();
   }

   public static function Erro_500($msg = null) {
      self::$statusCode = 500;
      self::$message = "Erro de server";
      self::$describle = $msg;
      self::execute();
   }
  
   public static function setError($severity, $message, $filepath, $line) {
      header("HTTP/1.0 500  Internal Server Error");
      header("Content-Type: text/html;charset=UTF-8");
      // echo"<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\">";
      echo "<div class=\"row\" style=\"margin-top:10px\"><div class=\"col-md-8 col-md-offset-2\"><div class=\"alert alert-danger\" role=\"alert\"><p><string>Mensagem: </strong>{$message}<br/>";
      echo "<string>Arquivo: </strong>{$filepath}<br/>";
      echo "<string>Linha: </strong>{$line}<br/>";
      echo "<string>severity: </strong>{$severity}<br/>";
      echo "</p></div></div></div>";
      exit(1); // EXIT_ERROR
   }

}
