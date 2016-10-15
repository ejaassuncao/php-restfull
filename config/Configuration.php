<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config
 *
 * @author ELTON
 */

namespace config;

use core\interfaces\AbstractConfiguration;

class Configuration extends AbstractConfiguration {

   protected function config() {
      parent::setNamespaceController("test\controller");
      parent::setNamespaceValidateAnnotation("test\Validacao");
      parent::setModeOptimized(false);
      //parent::setActionDefault("gravar", "pessoa");
      // parent::setActionDefault('bemVindos', 'BoasVindasController');
      parent::setNamespaceAnnotation("test\attributes");
      // parent::setGlobalFilter(new \test\filters\ExceptionFilter());
      //parent::setGlobalFilter(new \test\filters\ModelValidation());
      // parent::setGlobalFilter(new \test\filters\UserFilter());
      //parent::setGlobalFilter(new \test\filters\PermissionFilter());
      parent::setGlobalFilter(new \core\filters\AttributesRunTime());
      parent::setGlobalFilter(new \core\filters\FilterModelValidation());
   }

}
