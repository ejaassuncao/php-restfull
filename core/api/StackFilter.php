<?php

namespace core\api;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:stackFilter
 */
use \core\helper\HbDataBinder;
use \core\api\HbRouter;

class StackFilter {

   private $listFilter, $controller, $objectExecuted, $param, $httpRequest, $return, $router, $metod;

   public function __construct(HbRouter $router, $controller, $objectExecuted, $param, $httpRequest,$metod) {
      $this->router = $router;
      $this->listFilter = $router->getFilters();
      $this->controller = $controller;
      $this->objectExecuted = $objectExecuted;
      $this->param = $param;
      $this->httpRequest = $httpRequest;
     $this->metod = $metod;
   }

   public function getRouter() {
      return $this->router;
   }

   public function getController() {
      return $this->controller;
   }

   public function getObjectExecuted() {
      return $this->objectExecuted;
   }
   
   public function getMetod() {
      return $this->metod;
   }

   public function getParam() {
      return $this->param;
   }

   public function getHttpRequest() {
      return $this->httpRequest;
   }

   public function setFilter($obj) {
      array_push($this->listFilter, $obj);
   }

   public function next() {
      $stackNext = next($this->listFilter);
      if ($stackNext) {
         return $stackNext->executing($this);
      }
      $this->return = $this->invoke($this->getController(), $this->getObjectExecuted(), $this->getParam());
   }

   public function getReturn() {
      return $this->return;
   }

   private function invoke($controller, $metod, $param) {
      if ($param == null) :
         return $metod->invoke($controller);
      elseif (is_string($param)) :       
         return $metod->invoke($controller, $param);
      else :
        
         $args = current($metod->getParameters());

         if($args==false){
             return $metod->invoke($controller);
         }
         
         if ($args->getClass() != null) {
            $object = HbDataBinder::arrayToObjectAnotation($param, $args->getClass()->getName());
            return $metod->invoke($controller, $object);
         } else {
            return $metod->invokeArgs($controller, $param);
         }

      endif;
   }

}
