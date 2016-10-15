<?php

namespace test\entity;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Pessoa
 */
class Pessoa {

   private $id;
   private $nome;
   private $email;

   /**
    * @Regex(exp="\([0-9]{2}\) [0-9]{4}\-[0-9]{4}", message ="Expressao invalida.")
    * 
    */
   private $fone;
   
   
   private $idade;

   function getIdade() {
      return $this->idade;
   }

   function setIdade($idade) {
      $this->idade = $idade;
   }

   function getId() {
      return $this->id;
   }

   function getNome() {
      return $this->nome;
   }

   function getEmail() {
      return $this->email;
   }

   function getFone() {
      return $this->fone;
   }

   function setId($id) {
      $this->id = $id;
   }

   function setNome($nome) {
      $this->nome = $nome;
   }

   function setEmail($email) {
      $this->email = $email;
   }

   function setFone($fone) {
      $this->fone = $fone;
   }

}
