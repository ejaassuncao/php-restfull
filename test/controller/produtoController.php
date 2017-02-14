<?php

namespace test\controller;

use \test\entity\Produto;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @Controller(produtos) 
 * @Transaction(elton, maria) 
 */
class produtoController {

   private $conection = null;

   public function form() {
      return "from";
   }

   public function __construct(Produto $valor = null) {
      echo "Inicia contrutor 'produtoController' <hr/>";
   }

   public function index() {
      echo '<hr>Bem vindos a Pagina de Produtos<hr>';
   }

   /**
    *  @Post(cadastrar)    
    */
   public function create(\test\entity\Venda $venda = null) {
      echo '<br/><span style="color:red">executou controller</span><br/>';
      var_dump($venda);
   }

   /**
    * @Put(editar)   
    */
   public function edit($produto = null) {
      echo '<br/><span style="color:red">executou controller</span><br/>';
      print_r('produto editado ' . $produto);
   }

   /**
    * @Get(buscar) 
    */
   public function find($args1 = 0, $args2 = 0, $args3 = 0) {
      echo '<br/><span style="color:red">executou controller</span><br/>';
      $r = '<hr/>';
      $r.= $args1 . '<br/>';
      $r.= $args2 . '<br/>';
      $r.= $args3 . '<br/>';
      $r.= '<hr/>';
      echo $r;
      return $r;
   }

   /**
    * @Get(buscar2) 
    */
   public function find2(Produto $produto = null) {

       var_dump($produto);
      
   }
   
   /**
    * @Get(filtro)
    * @test\attributes\ChecaPermissao(1,2)
    * @Autenticacao
    */
   public function gerarFiltro(){
      
      echo "<hr/> - executei o metodo: 'gerarFiltro'<hr/>";
      
      return;
      
       /**
       * Esse metodo pega qualquer anotacao que herda de HbFilter e executa
       * Isso é legal porque o usuario poderá criar suas proprias anotações e colocalá onde desejar.
       */
      
     //metodos para criar Attributes;
     $string = '
                 /** 
                  * Description of BoasVindasController
                  * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
                  * @versão: 1.0
                  * @copyright: (c) 2015,cbasistema.com.br
                  * @description:VendasController
                  */
                  /**
                  * @Controller(produtos)
                  * @Transaction
                  * @Autenticacao(elton,maria)
                  * @test\attributes\ChecaPermissao(1,2)
                  * 
                  */';
      
      //com esse codigo eu consigo ver quais metodos executar;
      $string = trim(str_replace(array("/", "*", " ", '\n'), "", trim($string)));
      $words = preg_split('/\n/', $string, -1, PREG_SPLIT_NO_EMPTY);
      $words = array_filter($words, 'trim');
   
     
      foreach ($words as $value) {    
         
         $value = str_replace( array(")","@"), "", $value);         
         $value = explode("(", $value);
         
         try {
            
            $v = strripos($value[0],"\\")? $value[0]:'test\\attributes\\' .trim($value[0]);
                       
            $file =BASE_PATH.$v.'.php'; 
                                  
            if(file_exists($file)){
               // echo "Anotacoes->{$file}<br>";
                require_once($file); 
                $obj =  (isset($value[1]))? new $v($value[1]):new $v();
                                
                //falta passar os argumentos para:
                $listFilter=null;
                $controller=null;
                $metod=null;
                $param=null;
                $httpRequest=null;
                $param = new \core\api\StackFilter($listFilter, $controller, $metod, $param, $httpRequest);
                                
                $obj->{'executing'}($param);
            }
            
         } catch (\Exception $exc) {
            echo 'entrou aqui';
            continue;
         }
      }
      
      echo '<hr/>';
   }

   /**
    * @Delete
    */
   public function delete(\test\entity\Venda $venda) {
       var_dump($venda);
   }

}
