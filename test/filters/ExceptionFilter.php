<?php

namespace test\filters;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Exception
 */
use core\interfaces\HbFilter;
use \core\api\StackFilter;

class ExceptionFilter extends HbFilter {

   public function executing(StackFilter $stack) {

      try {
         
         echo "executing antes -> ExceptionFilter<br/>";
        
         $stack->next();
         
         echo 'Dados Excpiton'.$stack->getReturn();         
         echo "executing pos -> ExceptionFilter<br/>";
         
         
      } catch (\Exception $e) {
         echo 'Exceção capturada: ' . $e->getMessage() . "<br/>";
      } finally {
         echo "executing finally -> ExceptionFilter<br/>";
      }
   }

}
