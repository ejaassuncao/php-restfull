<?php

namespace core\api;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:URL
 */
use config\Configuration;
use core\helper\HB_Error_Helper;

class HbUrl {
   
   private  $configuration;
   
   function __construct(Configuration $config) {
      $this->configuration = $config;     
   }
   
   //medos privados
   public function getController() {   
      $array = explode("/", $this->getControllerAction($this->configuration));        
      return $array[1];      
   }

   public  function getAction() {
      $array = explode("/",  $this->getControllerAction()); 
      return (isset($array[2])) ? $array[2] : null;
   }

   public  function getParam() {
      $array = explode("/",  $this->getControllerAction());
     
      if (!empty(filter_input(INPUT_SERVER, 'QUERY_STRING'))) { 
         $param =  $this->montaObjeto(filter_input(INPUT_SERVER, 'QUERY_STRING'));
      } elseif (isset($array[3])) {        
         $param =  $this->montaObjeto($array[3]);
      } else {   
         $param =  $this->getPostArray();
      }       
      return $param;
   }
   
   //medos privados
   private  function montaObjeto($param) {      
      if (strpos($param, '&') || strpos($param, '=') ):
         $retorno =array();
         $array = explode("&", $param);
         foreach ($array as $value):
            $item = explode("=", $value);            
            $retorno[$item[0]] = $item[1];
         endforeach;
         $param = $retorno;         
      endif;      
      return $param;
   }
   
   private function getPostArray() {
      $retorno=null;
      $file=false;
      if ($file) {         
         if(!count($_FILES)>0){
            HB_Error_Helper::Erro_404("files not found");
         }         
         $retorno = $_FILES['file'];                
         if (filter_input(INPUT_POST, 'data')) {
            $retorno['param'] = filter_input(INPUT_POST, 'data');
         }
      } else {   
         $json =file_get_contents('php://input');
         $retorno = json_decode($json, true);   
         if($retorno==null && $json !=null){
            //HB_Error_Helper::Erro_405("Json Invalid");
            HB_Error_Helper::Erro_406("Json Invalid");
         }
      }
      return $retorno;
   }
   
   private  function getControllerAction(Configuration $configuration = null) {
      $v1 = filter_input(INPUT_SERVER, 'PHP_SELF');
      $v2 = filter_input(INPUT_SERVER, 'SCRIPT_NAME');
      $v3 = str_replace($v2, "", $v1);

      if ($configuration != null) {
         $remove = str_replace("\\", "/", $configuration->getConfigurations()["namespaceController"] . "/");
         $v3 = str_replace($remove, "", $v3);
      }
      return $v3;
   }
}