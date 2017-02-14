<?php

namespace test\entity;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:ALgumaClasse
 */
class AlgumaClasse implements IAlgumaCoisa {

   private $categoria;

   public function __construct(Categoria $categoria) {
      $this->categoria =  $categoria;
   }

   public function getNome() {
      var_dump($this->categoria);
      return 'Nome da classe';
   }

}
