<?php

namespace test\entity;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Pessoa
 */
class Pessoa {

   /**
    *
    * @Range(min=1, max=99999) 
    */
   private $id;

   /**
    * @core\annotation_validate\Requerid   
    * @StringLength(100)
    */
   private $nome;

   /**
    * @Requerid(describle=E-MAIL,message=Preencha do campo {0})
    * @Email   
    */
   private $email;

   /**
    * @Requerid(describle=TELEFONE,message=Prencha o campo {0})
    * @Fone
    * @Regex(exp="^[0-9]{2}-([0-9]{8}|[0-9]{9})", message ="Expressao invalida.")
    */
   private $fone;

   /**
    * @Range(min=18, max=150, describle="Idade invalida nao pode ser menor que {0} e maior que {1}")
    * @Min(18)
    * @Max(150)
    */
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
