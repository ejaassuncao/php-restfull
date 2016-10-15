<?php

namespace test\entity;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:SubCategoria
 */
class Categoria {
   private $id, $descricao, $sessao;
   
   function getId() {
      return $this->id;
   }

   function getDescricao() {
      return $this->descricao;
   }

   function setId($id) {
      $this->id = $id;
   }

   function setDescricao($descricao) {
      $this->descricao = $descricao;
   }
   function getSessao() {
      return $this->sessao;
   }

   function setSessao(\test\entity\Sessao $sessao) {
      $this->sessao = $sessao;
   }


   


}
