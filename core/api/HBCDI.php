<?php

namespace core\api;

use \core\interfaces\AbstractMappingCDI;
use core\api\HbRouter;
use core\api\HbUrl;
use core\helper\HttpRequest;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:HBCDI
 */
class HBCDI {

   private $ClassController, $mappingCDI, $router, $url, $httpRequest, $isAnnotationInjection;

   public function __construct($class, AbstractMappingCDI $mappingCDI = null, HbRouter $router = null, HbUrl $url = null, HttpRequest $httpRequest = null) {
      $this->ClassController = $class;
      $this->mappingCDI = $mappingCDI;
      $this->router = $router;
      $this->url = $url;
      $this->httpRequest = $httpRequest;
      $this->isAnnotationInjection = $this->existeAnotationInject($this->ClassController);
      $this->loadClassCDI();
   }

   public function newInstance() {
      $ctrl =$this->recusive($this->ClassController, $this->isAnnotationInjection);      
      return $ctrl;
   }

   private function recusive($class, $isInjection) {     
      //e não pode existe a anotação offCDI
      if (count($class->getConstructor()) > 0 && count($class->getConstructor()->getParameters()) > 0 && $this->mappingCDI != null && $isInjection == true) {
         //aqui poderia ser recussivo para ela entrar a dentro e verificar se existe CDI       
         $param_array_object=array();
        
         foreach ($class->getConstructor()->getParameters() as $pa1) {         
            //$this->isOpcional = $pa1->isOptional();
            $classeParam = $pa1->getClass();
            $object = $this->mappingCDI->getObect($pa1->getClass()->getName());
            
            if ($object == null) {
               if (count($classeParam->getConstructor()) > 0 && count($classeParam->getConstructor()->getParameters()) > 0) {
                  $object = $this->recusive($classeParam, $this->existeAnotationInject($classeParam));                 
               } else {
                  $object = $classeParam->newInstance();
               }
               array_push($param_array_object, $object);
            } else {
               array_push($param_array_object, $object);
            }
         }
         
         return $class->newInstanceArgs($param_array_object);
      }
      return $class->newInstance();
   }

   private function loadClassCDI() {
      $this->mappingCDI->add(HbRouter::class, $this->router);
      $this->mappingCDI->add(HbUrl::class, $this->url);
      $this->mappingCDI->add(HttpRequest::class, $this->httpRequest);
      $this->mappingCDI->mappingClass();
   }

   private function existeAnotationInject($class) {
      if ($class->getConstructor() != null) {
         $comment_string = $class->getConstructor()->getDocComment();
         return HbAnotation::existAnnotation($comment_string, HbAnotation::$PARTTEN_INJECT_PARAM);
      }
      return false;
   }

}
