<?php

namespace core\api;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:MapAction
 */
use \core\api\MapMetod;

class MapAction{

   private $map, $mapMetod;

   function __construct(MapMetod $mapMetod) {
      $this->map = array();
      $this->mapMetod = $mapMetod;
   }

   public function mappingAction($reflectionClass, $controllerRota) {
      
      $metods = $reflectionClass->getMethods();

      for ($i = 0; $i < count($metods); $i++) {

         $metod = $reflectionClass->getMethod($metods[$i]->name);
         $comment_string = $metod->getDocComment();

         if ($metods[$i]->name == '__construct') continue;
        
         if (HbAnotation::existAnnotation($comment_string)) {
                     
            $output = HbAnotation::GetAnotation($comment_string, HbAnotation::$PARTTEN_GET_PARAM);            
            $this->adiciona($controllerRota, $output, $metods, $i);

            $output2 = HbAnotation::GetAnotation($comment_string, HbAnotation::$PARTTEN_POST_PARAM);
            $this->adiciona($controllerRota, $output2, $metods, $i);

            $output3 = HbAnotation::GetAnotation($comment_string, HbAnotation::$PARTTEN_PUT_PARAM);
            $this->adiciona($controllerRota, $output3, $metods, $i);

            $output4 = HbAnotation::GetAnotation($comment_string, HbAnotation::$PARTTEN_DELETE_PARAM);
            $this->adiciona($controllerRota, $output4, $metods, $i);
            
         } else {
           $this->add($controllerRota, strtolower($metods[$i]->name), $metods[$i]->name, null, false);
         }
      }//fim do for
            
   }

   private function adiciona($controllerRota, $output, $metods, $i) {
      $routeAnotation = false;
      if (isset($output[1])) {
         if (!empty($output[1])) {
            $action = $metods[$i]->name;           
            //se existe um nome na anotacao coloca o nome
            $anotacao = empty(strtolower($output[1][0])) ? strtolower($action) : strtolower($output[1][0]);
                       
            $metod1 = strtoupper($output[0][0]);  
            
            if (strpos($metod1, "(")) {           
               //se existe uma anotation com parametro.
               $metod1 = substr($metod1, 0, strpos($metod1, "("));              
               $routeAnotation = true;
            }
            
            $metod1 = str_replace("@", "", $metod1);  
            
            //mapeamento Gerais
            $this->add($controllerRota, $anotacao, $action, $metod1, $routeAnotation);  
                       
            //mapeamento para Metodos HTTP
            $this->mapMetod->add($controllerRota, $anotacao, $action, strtolower($metod1), $routeAnotation);                    
         }
      }
   }

   public function add($controller, $rota, $action, $metod, $routeAnotation) {    
      if($this->exist($controller, $rota)){
         \core\helper\HB_Error_Helper::Erro_406("'{$controller}->{$action}'Not permission duplication Action.");
      }  
      $this->map[$controller . "_" . $rota] = array('action' => $action, 'metod' => $metod, 'routeAnotation'=>$routeAnotation);      
   }

   public function get($controller, $rota) {
      return $this->map[$controller . "_" . $rota];
   }
   
   public function exist($controller, $rota) {
      $roteamento = $controller . "_" . $rota;
      return array_key_exists($roteamento, $this->map);
   }
   
    public function getMapMetod() {    
      return $this->mapMetod;
   }

}
