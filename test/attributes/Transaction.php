<?php

namespace test\attributes;
use core\interfaces\HbFilter;
/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Transaction
 */
class Transaction  extends HbFilter {
   
   var $nome;
   var $nome2;
   public function __construct($nome=null) {
      $this->nome = $nome;       
   }
      
   public function executing(\core\api\StackFilter $stack) {
      echo "executou transacao: $this->nome<br/>";  
      $stack->next();        
   }
   
}
