<?php

namespace test\attributes;
use core\interfaces\HbFilter;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:ChecaPermissao
 */
class ChecaPermissao extends HbFilter {
   
   public function executing(\core\api\StackFilter $stack) {
      echo "executou permissao<br/>";
      $stack->next();
   }
   
}
