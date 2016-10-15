<?php

namespace test\controller;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:VendasController
 */

/**
 * @Controller(venda)
 */
class VendasController {
   
   public function listar($param=null) {
      echo "controller VendasController -> listar";
   }
   
   public function index($param=null) {
      echo "executou controller VendasController";
   }
   
}
