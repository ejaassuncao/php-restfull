<?php

namespace core\api;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:HbAnotation
 */
class HbAnotation {

   public static $PARTTEN_CONTROLLER = "#@Controller\((.*?)\)#";
   public static $PARTTEN_TRANSACTION = "#@Transaction#";
   public static $PARTTEN_GET_PARAM = "#@Get\((.*?)\)|@Get#";
   public static $PARTTEN_POST_PARAM = "#@Post\((.*?)\)|@Post#";
   public static $PARTTEN_PUT_PARAM = "#@Put\((.*?)\)|@Put#";
   public static $PARTTEN_DELETE_PARAM = "#@Delete\((.*?)\)|@Delete#";
   public static $PARTTEN_EXIST_PARAM = "#@#";
   public static $PARTTEN_LIST_PARAM = "#@List\((.*?)\)#";

   public static function GetAnnotations($comment_string) {
      //$string = trim(str_replace(array("/", "*", " ", '\n'), "", trim($comment_string)));
      $string = trim(str_replace(array("/", "*", "", '\n'), "", trim($comment_string)));

      $words = preg_split('/\n/', $string, -1, PREG_SPLIT_NO_EMPTY);

      $words = array_map('trim', $words);

      return $words;
   }

   /**
    * 
    * @param type $anotationsController
    * @param type $PARTTEN_ANOTATION
    * @return the value of annotation...
    */
   public static function GetValue($anotationGetDocComment, $PARTTEN_ANOTATION) {
      preg_match_all($PARTTEN_ANOTATION, $anotationGetDocComment, $output, PREG_PATTERN_ORDER);
      if (empty($output[0][0])) {
         return null;
      }
      return strtolower($output[1][0]);
   }

   public static function AllAnnotation($string) {

      //com esse codigo eu consigo ver quais metodos executar;
      $string = trim(str_replace(array("/", "*", " ", '\n'), "", trim($string)));
      $words = preg_split('/\n/', $string, -1, PREG_SPLIT_NO_EMPTY);
      $words = array_filter($words, 'trim');

      foreach ($words as $value) {

         $value = str_replace(array(")", "@"), "", $value);
         $value = explode("(", $value);

         try {

            $v = 'test\\attributes\\' . trim($value[0]);
            $file = BASE_PATH . $v . '.php';

            if (file_exists($file)) {
               echo "Anotacoes->{$file}<br>";
               require_once($file);
               $obj = (isset($value[1])) ? new $v($value[1]) : new $v();

               //falta passar os argumentos para:
               $listFilter = null;
               $controller = null;
               $metod = null;
               $param = null;
               $httpRequest = null;
               $param = new \core\api\StackFilter($listFilter, $controller, $metod, $param, $httpRequest);

               $obj->{'executing'}($param);
            }
         } catch (\Exception $exc) {
            echo 'entrou aqui';
            continue;
         }
      }
   }

   public static function GetAnotation($anotationGetDocComment, $PARTTEN_ANOTATION) {
      preg_match_all($PARTTEN_ANOTATION, $anotationGetDocComment, $output, PREG_PATTERN_ORDER);
      return $output;
   }

   public static function existAnnotation($anotationGetDocComment, $PARTTEN_ANOTATION = null) {
      if ($PARTTEN_ANOTATION == null) {
         return self::containAnotation($anotationGetDocComment);
      }
      preg_match_all($PARTTEN_ANOTATION, $anotationGetDocComment, $output, PREG_PATTERN_ORDER);
      return !empty($output[0][0]);
   }

   private static function containAnotation($anotationGetDocComment) {
      preg_match_all(HbAnotation::$PARTTEN_EXIST_PARAM, $anotationGetDocComment, $output, PREG_PATTERN_ORDER);
      if (isset($output[0]))
         if (!empty($output[0][0]))
            return TRUE;
      return FALSE;
   }

   public static function GetAnnotationValue($anotation) {
      
      $arrobapos = strpos($anotation, "@");
      
      if($arrobapos !== 0) return null;
      
      $value001 = substr_replace($anotation, '', $arrobapos, 1); //remove o @
      
      if(strpos($anotation,"(") > -1){      
         $fistChar = strripos($value001, ")");
         $value001 = substr_replace($value001, '', $fistChar, 1); //remove o (
         $primaryChar = strpos($value001, "(");
         $value001 = substr_replace($value001, '___', $primaryChar, 1); //remove o (
         return explode("___", $value001);
      }      
      return  $value001;      
   }

}
