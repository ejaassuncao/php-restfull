<?php

namespace core\api;

use \core\helper\HB_Error_Helper;
use \config\Configuration;
use \core\api\MapController;

/**
 * Description of init
 *
 * @author ELTON
 * @description: /Na verdade é um facade, facilita a manipulação dos metodos
 */
class HbRouter {

   private $mapController = null;
   private $mapAction;
   private $mapMetod;
   private $config;

   function __construct(Configuration $config, MapController $mapController) {
      $this->config = $config->getConfigurations();
      $this->mapController = $mapController;      
      $this->mapAction  = $this->mapController->getMapAction();      
      $this->mapMetod =  $this->mapAction->getMapMetod();
   }

   public function getMappingController() {      
      return $this->mapController;
   }
   
   public function getMappingAction() {      
      return $this->mapAction;
   }
   
   public function getMappingMetod() {      
      return $this->$this->mapMetod;
   }
   
   
   //metodos publicos...
   public function getController($controller) {
      $rota = $this->checkController($controller);
      return str_replace('Controller', '', $this->mapController->get($rota)['controller']) . 'Controller';
   }

   public function getAction($controller, $action) {
      $ctr = $this->checkController($controller);
      $acao = $this->checkAction($ctr, $action);
      return $this->mapAction->get($ctr, $acao)['action'];
   }

   public function getActionMetod($controller, $metodHttp) {
      $ctr = $this->checkController($controller);
      $metodHttp = strtolower($metodHttp);

      if ($this->mapMetod->count($ctr, $metodHttp)>1) {
         \core\helper\HB_Error_Helper::Erro_406("'{$ctr}->{$metodHttp}'Duplication metod .");
      }
      
      if (!$this->mapMetod->exist($ctr, $metodHttp)) {
         $acao = $this->checkAction($ctr, "");
        // return $this->mapAction->get($ctr, $acao)['action'];
          return $this->mapAction->get($ctr, $acao)['anotation'];
      }

      //return $this->mapMetod->get($ctr, $metodHttp)['action'];
      return $this->mapMetod->get($ctr, $metodHttp)['anotation'];
   }

   public function getMetod($controller, $action) {
      $ctr = $this->checkController($controller);
      $acao = $this->checkAction($ctr, $action);
      return $this->mapAction->get($ctr, $acao)['metod'];
   }

   public function getFilters() {
      return $this->config['filters'];
   }

   public function getConfig() {
      return $this->config;
   }
   
   public function getMappingCDI() {
      return $this->config['MappingCDI'];
   }

   public function getNamespaceAnnotation() {
      if (isset($this->config['namespaceAnnotation'])) {
         return $this->config['namespaceAnnotation'];
      }
      return '';
   }
      
   public function getNamespaceValidateAnnotation() {
      if (isset($this->config['namespaceValidateAnnotation'])) {
         return $this->config['namespaceValidateAnnotation'];
      }
      return '';
   }   

   //metodos privados     
   private function checkController($controller) {
      $rota = strtolower(str_replace('Controller', '', $controller));
      if (empty($controller) && isset($this->config['controllerDefault'])) {
         $rota = strtolower(str_replace('Controller', '', $this->config['controllerDefault']));
      }
      if (!$this->mapController->exist($rota)) {       
         HB_Error_Helper::Erro_404("'{$rota}' Controller not found.");        
      }
      return $rota;
   }

   private function checkAction($ctr, $action) {      
      
      if (empty($action) && isset($this->config['actionDefault'])) {
         $action = strtolower($this->config['actionDefault']);
      } else {
         $action = strtolower($action);
      }

      if (!$this->mapAction->exist($ctr, $action)) {
         HB_Error_Helper::Erro_404("'{$ctr}->{$action}' Action does not exist.");
      }

      return $action;
   }

}
