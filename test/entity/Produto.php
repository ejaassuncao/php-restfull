<?php

namespace test\entity;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Produto
 */
class Produto {
   
   var $id,$nome,$preco, $categoria;
    
   function __construct($param=null) {
      $this->nome = $param;
   }
   
   function getId() {
      return $this->id;
   }

   function getNome() {
      return $this->nome;
   }

   function getPreco() {
      return $this->preco;
   }

   function setId($id) {
      $this->id = $id;
   }

   function setNome($nome) {
      $this->nome = $nome;
   }

   function setPreco($preco) {
      $this->preco = $preco;
   }

   function getCategoria() {
      return $this->categoria;
   }

   function setCategoria(\test\entity\Categoria $categoria) {
      $this->categoria = $categoria;
   }
   
}
