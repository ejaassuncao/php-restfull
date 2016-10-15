<?php

namespace core\api;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:ModelContent
 */
class ModelContent {

   private $attributeName, $attributeValue, $stack, $parm;

   public function __construct($attributeName, $attributeValue, $stack, $parm) {
      $this->attributeName = $attributeName;
      $this->attributeValue = $attributeValue;
      $this->stack = $stack;
      $this->parm = $parm;
   }

   private function getValue($parm, $char) {
      if ($parm != null) {
         if (strpos($parm, $char)) {
            return explode($char, $parm);
         }
         return $parm;
      }
      return null;
   }

   public function getParmValue($attr) {    
      $a = $this->getValue($this->parm, ","); 
      if (is_array($a)) {
         foreach ($a as $value) {
            $b = $this->getValue($value, "=");
            if (trim($b[0]) == trim($attr)) {
               return str_replace('"', '', trim($b[1])) ;
            }
         }
      } else {
         $b = $this->getValue($a, "=");
         if (trim($b[0]) == trim($attr)) {
            return str_replace('"', '', trim($b[1])) ;
         }
      }
   }

   public function getAttributeName() {
      return $this->attributeName;
   }

   public function getAttributeValue() {
      return $this->attributeValue;
   }

   public function getStack() {
      return $this->stack;
   }

}
