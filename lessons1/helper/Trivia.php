<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

// мелкие вспомогательные функции
class Trivia{

    public $var = 0;
    public function __construct(){
//        echo "I'm construck";
    }

    public static function pr($string){ // print_r
        echo "<pre>";
        print_r($string);
        echo "</pre>";
    }
    public static function alert($string){
        echo "<script>";
        echo "alert('".$string."');";
        echo "</script>";
    }
}