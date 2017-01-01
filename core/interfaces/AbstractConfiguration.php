<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description: Classe de Helper para Retornar erros do server.
 */

namespace core\interfaces;

abstract class AbstractConfiguration {

   private static $configurations = null;

   protected abstract function config();

   public function __construct() {
      if (self::$configurations == null) {
         self::$configurations['modeOptimized'] =false;
         self::$configurations['viewTimePerformace'] = false;
         self::$configurations['filters'] = array();
         $this->config();
        // $this->loadFilters();
      }
   }
   
   protected function viewTimePerformace() {
       self::$configurations['viewTimePerformace'] = true;
   }
   
   function loadFilters() {
      //filtros no sistema
      //pode deixar para o usuario setar se ele quer utilizar ow não
     // array_push(self::$configurations['filters'], new \core\filters\AttributesRunTime());
     // array_push(self::$configurations['filters'], new \core\filters\FilterModelValidation);
   }

   protected function setNamespaceController($namespaceController) {
      self::$configurations['namespaceController'] = $namespaceController;
      self::$configurations['pathAbsController'] = BASE_PATH . $namespaceController . DIRECTORY_SEPARATOR;
   }

   protected function setActionDefault($actionDefault,$controller) {
      self::$configurations['actionDefault'] = $actionDefault;
      self::$configurations['controllerDefault'] = $controller;
   }
   
   protected function setNamespaceAnnotation($namespaceAnnotation) {
      self::$configurations['namespaceAnnotation'] = $namespaceAnnotation;
   } 
   
   public static function setNamespaceValidateAnnotation($namespaceValidateAnnotation) {
      self::$configurations['namespaceValidateAnnotation'] = $namespaceValidateAnnotation;
   }
      
   protected function setGlobalFilter(HbFilter $param) {     
      array_push(self::$configurations['filters'], $param);
   }
   
   protected function setModeOptimized($boolean) {
      self::$configurations['modeOptimized']= true;
   }
   
   public function getConfigurations() {
      return self::$configurations;
   }

  

}
