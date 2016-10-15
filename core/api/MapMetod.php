<?php

namespace core\api;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:MapAction
 */
class MapMetod {

   private $map;

   function __construct() {
      $this->map = array();
   }

   public function add($controller, $route, $action, $metod, $routeAnotation = false) {
    
    // if (!$routeAnotation) {      //para que serve esse if aqui??????????????????
         if ($this->exist($controller, $metod)) {
            $this->map[$controller . "_" . $metod . "_" . $action] = array('action' => $action, 'anotation' => $route, 'routeAnotation' => $routeAnotation);
         } else {
            $this->map[$controller . "_" . $metod] = array('action' => $action, 'anotation' => $route, 'routeAnotation' => $routeAnotation);
         }
   //  }
     
   }

   public function get($controller, $metod) {
      return $this->map[$controller . "_" . $metod];
   }

   public function exist($controller, $metod) {
      $roteamento = $controller . "_" . $metod;
      return array_key_exists($roteamento, $this->map);
   }

   public function count($controller, $metod) {
      $roteamento = $controller . "_" . $metod;
      $contador = 0;
      foreach (array_keys($this->map) as $key) {
         $v = explode("_", $key);
         $str = $v[0] . "_" . $v[1];
         if ($roteamento == $str) {
            $contador++;
         }
      }
      return $contador;
   }
}
