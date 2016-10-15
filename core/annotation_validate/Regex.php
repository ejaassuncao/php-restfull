<?php

namespace core\annotation_validate;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:RegExp
 */
class Regex extends \core\interfaces\AttributeValidation {

   public function execute(\core\api\ModelContent $modelContent) {
      $valor = $modelContent->getAttributeValue();
      $exp = $modelContent->getParmValue("exp");
      $message = $modelContent->getParmValue("message");      
      if (!ereg ($exp, $valor)){
         $this->addMsgError($message);
      }
      
   }

}
