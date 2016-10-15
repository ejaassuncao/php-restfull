<?php

namespace test\filters;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:UserFilter
 */

use core\interfaces\HbFilter;


class UserFilter extends HbFilter{
    
  
    public function executing(\core\api\StackFilter $stack) {
           
       echo  "executing antes -> UserFilter<br/>";
       
       $stack->next();
       
       echo ' dados User:' . $stack->getReturn();
       echo  "executing pos -> UserFilter<br/>";  
      
   }

}
