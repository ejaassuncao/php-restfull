<?php

namespace core\interfaces;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:AttributteValidation
 */
abstract class AttributeValidation {
    
  public $msg;
 
  public abstract function execute(\core\api\ModelContent $modelContent);
  
  protected function addMsgError($msg){
     $this->msg=$msg;
  }  
}
