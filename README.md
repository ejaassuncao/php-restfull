# PHP Restfull

Framework php para se trabalhar com restfull. Este framework traz o conceitos de alguns frameworks famosos no mundo java como: o Vraptor (http://www.vraptor.org/pt/), Spring framework e JAX-RS(https://jersey.github.io) etc..
## Recursos
  - Criar classes controladoras para controlar todas as request que vem do front-end.
  - Usar anotações no controller para trabalar com o verbo HTTP GET, POST, PUT, DELETE; 
  - Parsear dados e bind do modelo de Request Json para Objeto e de Objeto para Json;
  - Criar filtros nivel global, para controles de transaçõe, commits, e excessões;
  - Anotar filtros de nivel de ações. para controles de permissões etc..
  - Usar CDI (Injeção de dependecia) nos controles os nas classes de modelo. Usar interface para Injeções de dependencia. Maperar classes para utilização de CDI.
  - Usar anotações de validações ou criar suas anotações para validar a entrada de dados do seu modelo.
  - Tipar modelo de dados para Bindar seus modelos de acordo com a request em formado json.
Como esses recuso fica simples trabalhar com as requisições vindas do front-End.
O Php Restful trabalhar com as rotas da seguinte forma:
> [protocolo]://[apicaçção]/controlador/acao[ ? ou /]paramentos
>[http]://api/meuController/mensagem/texto="ola mundo"
ou
>[http]://api/meuController/mensagem?texto="ola mundo"

## Exemplos:
- Exemplo 01
Criar seu primeiro controler que imprime a mensagem "Ola Mundo";
Imaginando que nosso projeto chamasse API:

Chamada na url: http://api/boas-vindas/home
saida: "ola mundo"
Codigo:
```sh
<?php

namespace test\controller;

/**
 * @Controller(boas-vindas)
 * 
 */
class BoasVindasController {
   
   /*
   * @Get(home)
   */
   public function index() {
      echo "olha mundo";
   }
}
```

Exite um arquivo de configuração onde poderá definir a rota default e a acão dos controles default.
Veja o parametro "setActionDefault" onde definiu o controle inicial e a action default dos controles.
Nesse casso poderiamos apenas chamar a Url
Chamada na url: http://api/
O framework irá procurar o controlador inicial e executar o ação "Index";
Caso fosse um outro controler na configurações teriamos informar na Url o controler a ser chamando. O "index" sempre ira executar caso não informe uma ação.

```sh
<?php

namespace config;

use core\interfaces\AbstractConfiguration;

class Configuration extends AbstractConfiguration {
   protected function config() {
   
      parent::setNamespaceController("test\controller");
      
      parent::setActionDefault('index', 'BoasVindasController');
      
      parent::onCDI();
      //parent::onCDI(new \test\cdi\MyClasseCDI());
      
      parent::setModeOptimized();
      
      parent::setNamespaceAnnotation("test\attributes");
      
      parent::setNamespaceValidateAnnotation("test\validacao");
      
       parent::setGlobalFilter(new \core\filters\AttributesRunTime());
       
       parent::setGlobalFilter(new \core\filters\FilterModelValidation());
   }
}

```
Existem outros parametos na classe "Configuration"
- "setNamespaceController"  Este parametro é obrigatório  é o "local" diretorio onde vão estar todos seus controladores.
-"setNamespaceAnnotation" local onde ficará as classes de anotações dos controles
-"setNamespaceValidateAnnotation" local onde fica as classes de validações dos modelos;
-"setGlobalFilter" setar as classes de de filtros globais;
- parent::onCDI(). parametro onde você liga o CDI no framework. caso tenha classes comples poderá colocar um classe para ser invocadas dentro do OnCDI;
"parent::onCDI(new \test\cdi\MyClasseCDI())" veja o exemplo abaixo:
 ```sh
<?php
    namespace test\cdi;
    
    class MyClasseCDI extends \core\interfaces\AbstractMappingCDI {
      
       public function mappingClass() {      
          parent::add(\test\entity\IAlgumaCoisa::class, new \test\entity\AlgumaClasse(new \test\entity\Categoria()));   
       }
       
    }
```
Nesse caso temos uma interface "IAlgumaCoisa" que implementa Uma classe concreta "AlgumaClasse" que por sua vez recebe uma categoria.
Assim sendo se criarmos um controlador com um construtor. O framework sabe criar um instacia da classe "IAlgumaCoisa"

```sh
<?php

namespace test\controller;

class BoasVindasController {
   
   private $produto;
   
   public function __construct(\sistema\model\gerador\entity\IAlgumaCoisa $produto){
      $this->produto = $produto;      
   }
   
   public function mostrarProduto() {
     var_dump($this->produto);
   }
}
```

Alguns Exemplos de anotações:

 ```sh

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace test\controller;

/**
 * Description of BoasVindasController
 *
 * @author ELTON
 */
class BoasVindasController {

   
   public function index() {
      echo "<hr>Boas vindas ao rest full-php<hr>";
   }
   
   /**
    * @Get
    */
   public function index3() {
      echo "<hr>Boas vindas controller3<hr>";
   }
   
   /**
    * @Get
    */
   public function index4() {
      echo "<hr>Boas vindas controller4<hr>";
   }

   /**
    * @Get(inicio)
    */
   public function index2() {
      echo "<hr>Boas vindas controller2<hr>";
   }

}
```

