<?php

namespace test\cdi;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:MyClasseCDI
 */
class MyClasseCDI extends \core\interfaces\AbstractMappingCDI {
   
   public function mappingClass() {      
      parent::add(\test\entity\IAlgumaCoisa::class, new \test\entity\AlgumaClasse(new \test\entity\Categoria()));   
   }

}
