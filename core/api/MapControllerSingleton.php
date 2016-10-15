<?php

namespace core\api;

use core\helper\HBCache;

class MapControllerSingleton extends \core\api\MapController {

   private static $key = '#version1_mapController';

   public static function getInstance(\config\Configuration $config, \core\api\MapAction $mapAction) {

      if (!HBCache::exist(self::$key)) {
         $object = new MapController($config, $mapAction);
         HBCache::setValor(self::$key, $object);
      }

      return HBCache::getValor(self::$key);
   }

}
