<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace test\controller;

/**
 * Description of BoasVindasController
 *
 * @author ELTON
 */
class BoasVindasController {

   /**
    * @Get
    */
   public function index3() {
      echo "<hr>Boas vindas controller3<hr>";
   }
   
   /**
    * @Get
    */
   public function index4() {
      echo "<hr>Boas vindas controller4<hr>";
   }

   /**
    * @Get(inicio)
    */
   public function index2() {
      echo "<hr>Boas vindas controller2<hr>";
   }

}
