<?php

namespace core\helper;

/**
 * @author: Elton Assunção <ewa.soft@gmail.com>, Elton John:cbasistema.com.br
 * @versão: 1.0
 * @copyright: (c) 2015,cbasistema.com.br
 * @description:dataBinder
 */
use \core\api\HbAnotation;

class HbDataBinder {

    //Metodos Privados...
    private static function getAnnotationList($metod) {      
        $coment_string = $metod->getDocComment();
        preg_match_all(HbAnotation::$PARTTEN_LIST_PARAM, $coment_string, $output, PREG_PATTERN_ORDER);
        return (empty($output[1])) ? null : $output[1][0];
    }

    //Metodos Publicos...
    public static function arrayToObject($array, $object) {
       
        if (!is_object($object)) {
            $class = new \ReflectionClass($object);
            $obj = $class->newInstance();
        }
        foreach ($array as $key => $value) :
            $key = ucfirst($key);

            $metodoAhSerInvocado = 'set' . $key;

            try {
                //caso o metodo não existir, passa para o proximo
                $metodoReflexionado = $class->getMethod($metodoAhSerInvocado);
            } catch (\Exception $e) {
                continue;
            }

            $args = current($metodoReflexionado->getParameters());

            if ($args->getClass() != null) {
                $value = self::arrayToObject($value, $args->getClass()->getName());
            }
            $metodoReflexionado->invoke($obj, $value);
        endforeach;

        return $obj;
    }

    public static function arrayToObjectAnotation($array, $object) {
       
        if (!is_object($object)) {
            $class = new \ReflectionClass($object);
            $obj = $class->newInstance();
        }

        foreach ($array as $key => $value) :
            $key = ucfirst($key);
            $metodoAhSerInvocado = 'set' . $key;

            try {
                //caso o metodo não existir, passa para o proximo
                $metodoReflexionado = $class->getMethod($metodoAhSerInvocado);
            } catch (\Exception $e) {
                continue;
            }

            $args = current($metodoReflexionado->getParameters());
            if ($args->getClass() != null) {
                $value = self::arrayToObjectAnotation($value, $args->getClass()->getName());
            } elseif (is_array($value)) {
                $children = self::getAnnotationList($metodoReflexionado);
                if ($children != null && is_array($value)) {
                    $list = array();
                    foreach ($value as $item) {
                        if (is_array($item)) {
                            $v = self::arrayToObjectAnotation($item, $children);
                            array_push($list, $v);
                        }
                    }
                    $value = $list;
                }
            }
            $metodoReflexionado->invoke($obj, $value);
        endforeach;

        return $obj;
    }

    public static function toArray($objeto) {
        if ($objeto == null) {
            return $this->toArray($this);
        }
        $function = new ReflectionClass($objeto);
        $array = (array) $objeto;
        $novArray = null;
        foreach ($array as $key => $value) {
            $novaChave = trim(str_replace($function->name, "", $key));
            if (is_object($value)) {
                $value = $this->toArray($value);
            }
            $novArray[$novaChave] = $value;
        }
        return $novArray;
    }

}
