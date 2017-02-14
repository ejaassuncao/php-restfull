<?php

namespace test\controller;

use \core\api\HbRouter;
use \core\helper\HttpRequest;
use \core\api\HbUrl;
use sistema\model\gerador\entity\Produto;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:HelpController
 */
class HelpController {

   private $router, $url, $httpRequest, $produto;

//   public function __construct() {
//      $this->produto = new Produto ();
//   }

   public function __construct(\sistema\model\gerador\entity\IAlgumaCoisa $produto){
      $this->produto = $produto;      
   }
//   
//   public function __construct(HbRouter $router, HbUrl $url, HttpRequest $httpRequest, Produto $produto) {      
//      $this->router = $router;
//      $this->url = $url;
//      $this->httpRequest= $httpRequest;   
//      $this->produto = $produto;   
//   }

   function Index() {
      print_r('<pre>');      
      echo $this->produto->getNome();
   }   
  

}
