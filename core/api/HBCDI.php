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

   private $class, $mappingCDI;
   private $nome_variavel_parm, $nome_class_parm, $isOpcional;
   private $param_array_object;

   public function __construct($class, AbstractMappingCDI $mappingCDI=null, HbRouter $router =null, HbUrl $url=null, HttpRequest $httpRequest=null) {
      $this->class = $class;
      $this->mappingCDI = $mappingCDI;
      $this->param_array_object = array();
      
      if($this->mappingCDI!=null){         
         $this->mappingCDI->add(HbRouter::class,$router);
         $this->mappingCDI->add(HbUrl::class,$url);
         $this->mappingCDI->add(HttpRequest::class,$httpRequest);
         $this->mappingCDI->mappingClass();
      }
   }

   public function newInstance() {
      if (count($this->class->getConstructor()) > 0 && count($this->class->getConstructor()->getParameters()) > 0 && $this->mappingCDI != null) {
         foreach ($this->class->getConstructor()->getParameters() as $pa1) {
            $this->nome_variavel_parm = $pa1->name; 
            $this->nome_class_parm =$pa1->getClass()->getName();
            $this->isOpcional = $pa1->isOptional();            
            $object = $this->mappingCDI->getObect($this->nome_class_parm); 
            if ($object == null) {              
               array_push($this->param_array_object, $pa1->getClass()->newInstance());
            } else {
               array_push($this->param_array_object, $object);
            }
         }
         return $this->class->newInstanceArgs($this->param_array_object);         
      }
      
      return $this->class->newInstance();
     
   }

}
