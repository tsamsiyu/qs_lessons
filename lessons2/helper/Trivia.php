<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

// мелкие вспомогательные функции
class Trivia{

    /*
     * pr - обычная print_r, только без дописывания pre
     */
    public static function pr($string){ // print_r
        echo "<pre>";
        print_r($string);
        echo "</pre>";
    }

    /*
     * alert - alert из js, без дописывания script
     */
    public static function alert($string){ // alert
        echo "<script>";
        echo "alert('".$string."');";
        echo "</script>";
    }

    /*
     * stripBoundaryQuotes - удаляет кавычки по краям строки
     */
    public static function stripBoundaryQuotes($string){ // удаляем крайние кавычки
        $string = trim($string);
        while(1){ // в этом цикле удаляем кавычки в начале строки
            if($string[0] == "'"){
                $string = substr($string, 1);
            }else{
                break;
            }
        }
        while(1){ // в этом цикле удаляем кавычки в конце строки
            if($string[strlen($string)-1] == "'"){
                $string = substr($string, 0, strlen($string)-1);
            }else{
                break;
            }
        }
        return $string;
    }

    /*
     * splitOnOperator - разбивает строку с арифметическим выражением следующим образом:
     *                  name > 'C' преобразует в array('begin'=>name,'separator'=>'>', 'end'=>'C');
     */
    public static function splitOnOperator($string){
        $separator = false;
        $field = array(); // сюда запишем результат
        for($i = 0; $i < strlen($string); $i++){
            switch($string[$i]){
                case "<": if($string[$i+1] == '='){$separator = '<=';}else{$separator = '<';} break;
                case ">": if($string[$i+1] == '='){$separator = '>=';}else{$separator = '>';} break;
                case "=": if($string[$i+1] == '='){$separator = '==';}else{$separator = '=';} break;
                case "!": if($string[$i+1] == '='){$separator = '!=';} break;
            }
            if($separator){
                $field['begin'] = trim(substr($string, 0, $i));
                $field['end'] = trim(substr($string, $i+strlen($separator)));
                $field['separator'] = $separator;
                break;
            }
        }
        return $field;
    }
}