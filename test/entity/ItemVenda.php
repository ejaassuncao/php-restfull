<?php

namespace test\entity;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:VendasProduto
 */
class ItemVenda {

   private $venda, $produto, $qtd, $valor_unitario;

   function getVenda() {
      return $this->venda;
   }

   function getProduto() {
      return $this->produto;
   }

   function getQtd() {
      return $this->qtd;
   }

   function getValor_unitario() {
      return $this->valor_unitario;
   }

   function setVenda($venda) {
      $this->venda = $venda;
   }


   function setProduto($produto) {
      $this->produto = $produto;
   }

   function setQtd($qtd) {
      $this->qtd = $qtd;
   }

   function setValor_unitario($valor_unitario) {
      $this->valor_unitario = $valor_unitario;
   }

}
