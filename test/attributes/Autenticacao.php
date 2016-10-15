<?php

namespace test\attributes;
use core\interfaces\HbFilter;
/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Autenticacao
 */
class Autenticacao extends HbFilter {
      
   private $_param;
   
   public function __construct($param) {
      $this->_param=$param;
   }

   public function executing(\core\api\StackFilter $stack) {
       echo "execuntando atenticacao passado o valor: {$this->_param}<br/>"; 
               
       $stack->setFilter( new \test\attributes\ChecaPermissao() );
       echo "<br/>";
       
       print_r($stack->getParam());
       echo "<br/>"; 
       
       print_r($stack->getHttpRequest());
       echo "<br/>"; 
       
       print_r($stack->getObjectExecuted());
       echo "<br/>"; 
       
       print_r($stack->getMetod());
       echo "<br/>"; 
        
       print_r($stack->getController());
       echo "<br/>"; 
      // var_dump($stack);
       
       
       $stack->next();
   }

//put your code here
}
