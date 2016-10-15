<?php

namespace core\api;

use \core\api\HbRouter;
use \core\helper\HB_Error_Helper;
use \core\api\StackFilter;
use \core\helper\HttpRequest;
use \core\api\HbUrl;

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
      if (!empty($controllerUrl) && !isset($this->router->getConfig()['controllerDefault'])):

         if (empty($actionUrl)) {
            $actionUrl = $this->router->getActionMetod($controllerUrl, $metodoUrl); 
         }
         
         //valida metodos http corretos
         $httpMetod = $this->router->getMetod($controllerUrl, $actionUrl);

         if ($httpMetod != $metodoUrl && $httpMetod != null) {
            HB_Error_Helper::Erro_405("Method Not Allowed");
         }
         
      endif;

      $objectExecuted = $class->getMethod($this->router->getAction($controllerUrl, $actionUrl));
      
      //instancia o controller
      //Esse cara aqui Aplica o CDI (Injecao de Dependencia) new modelCDI($class);
      // $c = new \test\entity\Produto(1, 'Elton', 3.76);
      // $object = $class->newInstance($c);      
//      foreach ($class->getConstructor()->getParameters() as $pa1) {
//         // param name
//         var_dump($pa1->name);
//
//         // param type hint (or null, if not specified).
//         var_dump($pa1->getClass()->name);
//
//         // finds out if the param is required or optional
//         var_dump($pa1->isOptional());
//      }
      //var_dump($class);
      $controller = $class->newInstance();

      
      //Criar a classe binder para
      //$modelo = new ModelBinder($param)
      //      foreach ($metod->getParameters() as $p) {
      ////         // param name
      ////         var_dump($p->name);
      ////         var_dump($p->isOptional());
      ////         var_dump($p->getClass() == null ? null : $p->getClass()->getName());
      //      }
      // var_dump($param);
      //Fazer toda parte de validação
     //  $modelo = new modelValidation($controller);
      //aqui vem uma lista de classes globais a serem executadas
      //execução 

      //*****Executa os Filtos**********
      $stack = new StackFilter($this->router, $controller, $objectExecuted, $paramUrl, $this->httpRequest, $metodoUrl);
      $filter = current($this->router->getFilters());
      if ($filter) {
         return $filter->executing($stack);
      }
      $stack->next();
   }

}
