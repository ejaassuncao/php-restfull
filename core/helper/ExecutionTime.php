<?php

namespace core\helper;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:ExecutionTime
 */
class ExecutionTime {

   private $startTime;
   private $endTime;

   public function Start() {
      $this->startTime =  round(microtime(true) * 1000); 
   }

   public function End() {
      $this->endTime = round(microtime(true) * 1000);
   }

   private function runTime() {
      return  $this->endTime - $this->startTime;
   }

   public function __toString() {
      return "Time execution (millisecond): " . $this->runTime();
   }

}
