<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

// factory and singleton

class App{
    private static $instance = array(); // в массиве храним наши объекты классов

    private function __construct(){} // все создания только через getInstance

    public static function getInstance($className="") // если параметр передан возвращаем обхект этого класса, иначе - сам класс
    {
        if(!$className || !class_exists($className)){
            $className = __CLASS__;
        }

        $key = 0; // ключ наличия объекта
        $object = false; // текущий объект
        foreach(self::$instance as $obj){
            if(is_a($obj, $className)){
                $key = 1;
                $object = $obj;
                break;
            }
        }
        if($key == 1){
//            echo 'Экземпляр класс '.$className.' существует.<br>';
            return $object;
        }else{
//            echo 'Создание нового экземпляра класса '.$className.'.<br>';
            $object = new $className;
            array_push(self::$instance, $object);
            return $object;
        }
    }
}