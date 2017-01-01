<?php

namespace core\filters;

use \core\api\HbAnotation;
use core\interfaces\AttributeValidation;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:FilterModelValidation-> Classe reponsável por  ler as anotações das entidades e valida-las.
 */
class FilterModelValidation extends \core\interfaces\HbFilter {

   public function executing(\core\api\StackFilter $stack) {
      //ele vai ler as anotações do objeto
      //vai executar as validações do objeto
      //essas validações retoran um objeto com erro e mensagem 
      //esse meu excutor imprime não tela o erro e não continua o processo
      $Messages = array();
      $metod = $stack->getObjectExecuted();

      $args = current($metod->getParameters());

      $nameSpace = array($stack->getRouter()->getNamespaceValidateAnnotation(), 'core\annotation_validate');

      $reflectionClass = $args->getClass();
      
      if ($reflectionClass==null) {
          return $stack->next();         
      }
      
      $props = $reflectionClass->getProperties(\ReflectionProperty::IS_PRIVATE);

      foreach ($props as $prop) {
         $prop->setAccessible(true);
         $comment = $prop->getDocComment();
         $anotations = HbAnotation::GetAnnotations($comment);
         $attributeName = $prop->getName();
         $attributeValue = $stack->getParam()[$attributeName];
                
         foreach ($anotations as $anotation) {  
           $arrayValue = HbAnotation::GetAnnotationValue($anotation);
                     
            try {
               
               $ArrayObj = $this->GetObject($arrayValue[0], $nameSpace); 
                              
               if(!isset($ArrayObj))                   
                   continue;                     
                             
               $strObj =   $ArrayObj['strObj']; 
               $file = $ArrayObj['file'];

               require_once($file);

               $obj =new $strObj(); 
               $parm = isset($arrayValue[1])?$arrayValue[1] :null;
              
               //Preenchar dados da Classe  
               $modelContent = new \core\api\ModelContent($attributeName, $attributeValue, $stack, $parm);
               
               $obj->execute($modelContent);

               if (isset($obj->msg)) {
                  array_push($Messages, $obj->msg);
               }
            } catch (\Exception $exc) {
               continue;
            }
         }
      }

      if (count($Messages) == 0) {
         return $stack->next();          
      }
      \core\helper\HB_Error_Helper::Erro_400($Messages);
   }

   private function Cast($obj, $strObj) {

      if (!$obj instanceof AttributeValidation) {
         \core\helper\HB_Error_Helper::Erro_500("Class {$strObj} not extend AttributeValidation. ");
      }
      return $obj;
   }
   
   private function GetObject($strObject, array $nameSpaces) {
            
      foreach ($nameSpaces as $nameSpace) {         
         //verifica se a notações é do usuario ou do frameork
         $strObj = strripos($strObject, DIRECTORY_SEPARATOR) ? $strObject : $nameSpace . DIRECTORY_SEPARATOR . trim($strObject);
         $file = BASE_PATH . $strObj . '.php';         
         if (file_exists($file)){
            return array('strObj'=>$strObj, 'file'=> $file);
         }
      }
      return null;
   }
}
