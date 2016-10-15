<?php

namespace core\helper;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:Arquivo
 */
class Arquivo {

   public static function fileDirecty($dirPath) {

      if (!is_dir($dirPath)) {
         HB_Error_Helper::Erro_500("Diretory not found: '{$dirPath}' ");
      }

      $diretorio = dir($dirPath);
      $files = array();

      while ($arquivo = $diretorio->read()) {

         if (is_file($dirPath . $arquivo)) {
            array_push($files, $arquivo);
         }
      }

      $diretorio->close();

      return $files;
   }

   public static function extensionFile($file) {
      $extensao = explode(".", $file);
      return '.' . end($extensao);
   }

}
