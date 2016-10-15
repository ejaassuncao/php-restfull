<?php

namespace test\entity;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Venda
 */
class Venda {

   private $id,
           $data,
           $itemVenda;

   function getId() {
      return $this->id;
   }

   function getData() {
      return $this->data;
   }

   function setId($id) {
      $this->id = $id;
   }

   function setData($data) {
      $this->data = $data;
   }

   function getItemVenda() {
      return $this->itemVenda;
   }
   
   /** 
    * @List(test\entity\ItemVenda)
    */
   function setItemVenda($itemVenda) {
      $this->itemVenda = $itemVenda;
   }

}
