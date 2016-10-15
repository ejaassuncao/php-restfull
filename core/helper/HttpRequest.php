<?php
namespace core\helper;
/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:HttpRequest
 */
class HttpRequest {
  
//   public static function getRequestMetod() {
//      return filter_input(INPUT_SERVER, 'REQUEST_METHOD');
//   }
   
   public static function Server($constant_name) {
      return filter_input(INPUT_SERVER, $constant_name);
   }
   
   public static function Cookie($constant_name) {
      return filter_input(INPUT_COOKIE, $constant_name);
   }
   
   public static function Get($constant_name) {
      return filter_input(INPUT_GET, $constant_name);
   }
   
   public static function Post($constant_name) {
      return filter_input(INPUT_POST, $constant_name);
   }
   
   public static function Request($constant_name) {
      return filter_input(INPUT_REQUEST, $constant_name);
   }
   
    public static function Session($constant_name) {
      return filter_input(INPUT_SESSION, $constant_name);
   }
   
   public static function Env($constant_name) {
      return filter_input(INPUT_ENV, $constant_name);
   }
   
   
   
}
