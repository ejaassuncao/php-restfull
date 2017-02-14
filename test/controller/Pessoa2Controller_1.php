<?php

namespace test\controller;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Pessoa
 */

/**
 * @Controller(pessoa)
 * 
 */
class Pessoa2Controller_1 {
  
    /**
    *  @Post(grava)
    */
   public function gravar2(\test\entity\Pessoa $pessoa=null) {
      echo 'Passei por aqui';
      var_dump($pessoa);
   }

   /**
    * @Put
    */
   public function editar(\test\entity\Pessoa $pessoa=null) {
      var_dump($pessoa);
   }

   /**
    * @Delete
    */
   public function excluir($id) {
      echo $id;
   }

   /**
    * @Get
    * @Autenticacao(parametro=teste,teste2)
    * @test\attributes\Transaction
    */
   public function buscar($id,$fada) {
      echo "<hr/>Executou dados do da busca{$id}";
   }

}
