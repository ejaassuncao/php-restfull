<?php

namespace test\filters;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:PermissionFilter
 */
use core\interfaces\HbFilter;

class PermissionFilter extends HbFilter {

   public function executing(\core\api\StackFilter $stack) {
      echo "executing antes -> PermissionFilter<br/>";
      $stack->next(); 
       echo 'Dados Permission' .$stack->getReturn();
      echo "executing pos -> PermissionFilter<br/>";
   }
}
