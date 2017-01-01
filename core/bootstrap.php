<?php
/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description: Classe de Helper para Retornar erros do server.
 */

$version= '5.5.12';

if(phpversion() < $version){   
   die("<span style='color:red'>Error version!<br/> Version min {$version} requerid.</span>");     
}

$subject = dirname(__FILE__);

define("BASE_CORE", $subject . DIRECTORY_SEPARATOR);
define("BASE_CONFIG", str_replace('core', 'config', $subject . DIRECTORY_SEPARATOR));
define("BASE_PATH", str_replace('core', '', $subject));

include_once (BASE_CORE . 'api' . DIRECTORY_SEPARATOR . 'function_error.php');
include_once (BASE_CORE . 'api' . DIRECTORY_SEPARATOR . 'include.php');

$executionTime = new \core\helper\ExecutionTime();
$executionTime->Start();

$config = new config\Configuration();

$mapMetod = new \core\api\MapMetod(); 
$mapAction =  new \core\api\MapAction($mapMetod);

$mapController =  ($config->getConfigurations()['modeOptimized'])?  \core\api\MapControllerSingleton::getInstance($config, $mapAction): new core\api\MapController($config, $mapAction);

$router = new core\api\HbRouter($config, $mapController);

$url = new \core\api\HbUrl($config);

$httpRequest = new \core\helper\HttpRequest();

//inicia aplicação
core\api\HbCore::getInstance($router, $url, $httpRequest)->invoker();

$executionTime->End();


if(!$config->getConfigurations()['modeOptimized']){
   echo "<HR/>Time execution: ".$executionTime ."<HR/>";
}
