<?php

namespace test\controller;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Pessoa
 */

/**
 * @Controller(pessoa2)
 * 
 */
class Pessoa2Controller {
  
    /**
    *  @Post(grava)
    */
   public function gravar2(\test\entity\Pessoa $pessoa=null) {
      echo 'executei funcao';
     //var_dump($pessoa);
   }
   
}
