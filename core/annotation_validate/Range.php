<?php

namespace core\annotation_validate;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Range
 */
class Range extends \core\interfaces\AttributeValidation {

   public function execute(\core\api\ModelContent $modelContent) {
      $min = $modelContent->getParmValue("min");
      $max = $modelContent->getParmValue("max");
      $message = $modelContent->getParmValue("message");
      $value = $modelContent->getAttributeValue();
      $name = $modelContent->getAttributeName();
      
      if ($min == null) {
         return $this->addMsgError("Anotação range para o atributo {$name}, não informado o parametro (min)");
      }     
     
      if ($max == null) {
         return $this->addMsgError("Anotação range para o atributo {$name}, não informado o parametro (max)");
      }
      if (is_int($value) || is_double($value)) {
         if ($value < $min || $value > $max) {
            if (empty($message)) {              
               $this->addMsgError("O campo {$name} fora de interválo.");
            } else {
               $msg =  str_replace("{1}", $max, str_replace("{0}", $min, $message));
               $this->addMsgError($msg);
            }
         }
      }
   }

}
