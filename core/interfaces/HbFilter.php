<?php

namespace core\interfaces;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:HbFilter
 */
use core\api\StackFilter;

abstract class HbFilter {
        
   public abstract function executing(StackFilter $stack);
}
