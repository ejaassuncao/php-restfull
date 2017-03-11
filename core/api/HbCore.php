<?php

namespace core\api;

use \core\api\HbRouter;
use \core\helper\HB_Error_Helper;
use \core\api\StackFilter;
use \core\helper\HttpRequest;
use \core\api\HbUrl;
use \core\api\HBCDI;

/**
 * Description of init
 *
 * @author ELTON
 */
class HbCore {

   private $router, $url, $httpRequest;
   private static $HbCore = null; 

   private function __construct(HbRouter $router, HbUrl $url, HttpRequest $httpRequest) {
      $this->router = $router;
      $this->url = $url;
      $this->httpRequest = $httpRequest;
      $this->ActionUrl = $this->url->getAction();
   }

   public static function getInstance(HbRouter $router, HbUrl $url, HttpRequest $httpRequest) {
      if (self::$HbCore == null) {
         self::$HbCore = new HbCore($router, $url, $httpRequest);
      }
      return self::$HbCore;
   }

   public function invoker() {
      //inicializa minhas variais
      $controllerUrl = $this->url->getController();
      $actionUrl = $this->url->getAction();
      $paramUrl = $this->url->getParam();
      $metodoUrl = $this->httpRequest->Server('REQUEST_METHOD');

      //checa a existencia da classe e do metodo e criar a reflexao..
      $class = new \ReflectionClass($this->router->getController($controllerUrl));

      /**
       * Verifica se existe uma rota default configurada, se existir pega ela...
       * Caso não existir executa as action pelos metodos http;
       */
     
      //--------------------direciona para o controller configurado como default--------------
      if (!empty($controllerUrl) && !isset($this->router->getConfig()['controllerDefault'])):    
         if (empty($actionUrl)) {
            $actionUrl = $this->router->getActionMetod($controllerUrl, $metodoUrl);
         }
      endif;
    
      //-----------------------valida verbos http corretos-------------------------------------
      $httpMetod = $this->router->getMetod($controllerUrl, $actionUrl);
      
      if ($httpMetod != $metodoUrl && $httpMetod != null) {         
         HB_Error_Helper::Erro_405("Method Not Allowed");
      }
      
      $objectExecuted = $class->getMethod($this->router->getAction($controllerUrl, $actionUrl));

      //--------------------Inicia processo de CDI----------------------------------------------- 
      $cdi = ($this->router->getMappingCDI() != null) ? new HBCDI($class, $this->router->getMappingCDI(), $this->router, $this->url, $this->httpRequest) : new HBCDI($class);
      $controller = $cdi->newInstance();
      //--------------------Fecha processo de CDI------------------------------------------------    
      //*****Executa os Filtos**********
      $stack = new StackFilter($this->router, $controller, $objectExecuted, $paramUrl, $this->httpRequest, $metodoUrl);
      $filter = current($this->router->getFilters());
      if ($filter) {
         return $filter->executing($stack);
      }
      $stack->next();
   }

}
