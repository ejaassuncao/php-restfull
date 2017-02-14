<?php

namespace core\interfaces;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:MappingCDI
 */
abstract class AbstractMappingCDI {

   private $arrayClass;

   public function __construct() {
      $this->arrayClass = array();
   }

   public abstract function mappingClass();

   public function add($key, $object) {
      array_push($this->arrayClass, array(strtolower($key) => $object));
   }

   public function getObect($key) {
      $keyLower =strtolower($key);
      foreach ($this->arrayClass as $value) {       
         if (array_key_exists($keyLower, $value)) {
            return $value[$keyLower];           
         }
      }
      return null;
   }

}
