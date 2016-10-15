<?php

namespace core\filters;

use \core\api\StackFilter;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Classe responsavel por pegar as anotações criadas pelos desenvolvedores e executar.
  */
class AttributesRunTime extends \core\interfaces\HbFilter {

   private function replaceString($paramString) {
      $string = trim(str_replace(array("/", "*", " ", '\n'), "", trim($paramString)));
      $words = preg_split('/\n/', $string, -1, PREG_SPLIT_NO_EMPTY);
      return array_filter($words, 'trim');      
   }

   private function readAnotationsClass(StackFilter $stack) {
      $reflectionClass = new \ReflectionClass($stack->getController());
      $string = $reflectionClass->getDocComment();
      return $this->replaceString($string);
   }

   private function readAnotationsMetod(StackFilter $stack) {
      return $this->replaceString($stack->getObjectExecuted()->getDocComment());
   }

   private function executeAnotations(StackFilter $stack, $words) {         
      $path_attribute = $stack->getRouter()->getNamespaceAnnotation();      
      foreach ($words as $item) {
         $value001 = str_replace(array(")", "@"), "", $item);
         $value = explode("(", $value001);
         try {
            $v = strripos($value[0], DIRECTORY_SEPARATOR) ? $value[0] : $path_attribute . DIRECTORY_SEPARATOR . trim($value[0]);
            $file = BASE_PATH . $v . '.php';
            if (file_exists($file)) {
               require_once($file);
               $obj = (isset($value[1])) ? new $v($value[1]) : new $v();
               //$param = new \core\api\StackFilter($listFilter, $controller, $metod, $param, $httpRequest);
               //$obj->{'executing'}($param);
               $stack->setFilter($obj);
            }
         } catch (\Exception $exc) {
            continue;
         }
      }
   }

   public function executing(StackFilter $stack) {

      $wordsHead = $this->readAnotationsClass($stack);
      $this->executeAnotations($stack, $wordsHead);

      $wordsBody = $this->readAnotationsMetod($stack);
      $this->executeAnotations($stack, $wordsBody);

      //continua o processo;
      $stack->next();
   }

}
