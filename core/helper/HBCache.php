<?php

namespace core\helper;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Cache
 */
class HBCache {

   private static function checck(){
      if (session_id() === '') {
         session_start();
      }
   }
   
   public static function setValor($key, $value) {     
      self::checck();      
      $_SESSION[$key] =  $value;
    //  $_SESSION[$key] =  serialize($value);
   }

   public static function getValor($key) {
      self::checck();
      return $_SESSION[$key];
     // return unserialize($_SESSION[$key]);
   }

   public static function exist($key) {
      self::checck();      
      return (isset($_SESSION[$key]) ? true : false);
   }

}
