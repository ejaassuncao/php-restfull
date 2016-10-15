<?php

namespace core\api;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:MapController
 */
use \core\api\MapAction;
use \config\Configuration;
use \core\helper\Arquivo;

class MapController {

   private $map, $config, $mapAction;

   function __construct(Configuration $config, MapAction $mapAction) {
      $this->map = array();
      $this->config = $config->getConfigurations();
      $this->mapAction = $mapAction;     
      $this->mappingController();
   }
     
   private function mappingController() {
      if (!isset($this->config['pathAbsController'])) {
         \core\helper\HB_Error_Helper::Erro_404("Not found configuration 'setNamespaceController'.");
      }
      
      $controllers = Arquivo::fileDirecty($this->config['pathAbsController']);
      
      foreach ($controllers as $file) {
         
         $file = $this->config['namespaceController'] . '\\' . str_replace(Arquivo::extensionFile($file), '', $file);
         
         $reflectionClass = new \ReflectionClass($file);
         
         $anotationsController = $reflectionClass->getDocComment();

         $class = $reflectionClass->getName();

         $transaction = HbAnotation::existAnnotation($anotationsController, HbAnotation::$PARTTEN_TRANSACTION);

         $anotacao1 = HbAnotation::GetValue($anotationsController, HbAnotation::$PARTTEN_CONTROLLER);
                   
         $anotacao = $anotacao1 != null ? strtolower($anotacao1) : strtolower(str_replace($reflectionClass->getNamespaceName() . "\\", "", str_replace("Controller", "", $class)));

         //$outros = HbAnotation::AllAnnotation($anotationsController); 
         // var_dump($anotationsController, $class, $anotacao, $transaction, $outros);
         
         $this->add($anotacao, $class, $transaction);
         $this->mapAction->mappingAction($reflectionClass, $anotacao);
               
      }
      
   }

   private function add($rota, $ctrl, $transation) {
      if ($this->exist($rota)) {
         \core\helper\HB_Error_Helper::Erro_406("'{$controller}' Not permission duplication controller.");
      }
      $this->map[$rota] = array('controller' => $ctrl, 'transation' => $transation);
   }

   public function get($rota) {
      return $this->map[$rota];
   }

   public function exist($rota) {      
      return array_key_exists($rota, $this->map);
   }
   
   public function  getMapAction(){
      return $this->mapAction;
   }   

}
