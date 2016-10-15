<?php

namespace core\annotation_validate;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description: Requerid: Classe reposável por validar se existe conteúdo na string
 * @param String $describle, $message 
 */
class Requerid extends \core\interfaces\AttributeValidation {

   public function execute(\core\api\ModelContent $modelContent) {
      if (is_string($modelContent->getAttributeValue())) {
         $this->Valida($modelContent);
      }
   }

   private function valida(\core\api\ModelContent $modelContent) {
      $describle = $modelContent->getParmValue('describle');
      $message = $modelContent->getParmValue('message');
      if (empty($modelContent->getAttributeValue()) || $modelContent->getAttributeValue() == NULL) {
         $describleName = ( $describle == null) ? $modelContent->getAttributeName() : $describle;
         if ($message != null) {           
            $msg =str_replace("{0}", $describle, $message);
            $this->addMsgError($msg);
         } else {
            $this->addMsgError("Field {$describleName} requerid.");
         }
      }
   }

}
