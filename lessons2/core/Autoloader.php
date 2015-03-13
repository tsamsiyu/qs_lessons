<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class Autoloader{
    public static function init(){
        spl_autoload_register(function($className){ // вызываем функцию регистрации классов php
            if(file_exists(CONFIG.'base.php')){
                $config = require(CONFIG.'base.php'); // пути загрузки классов берем из базового конфига
                array_push($config['router'], CONTROLLER, MODEL); // добавляем обязательные папка
//        echo "<pre>";
//        print_r($config);
//        echo "</pre>";
                foreach($config['router'] as $path){
                    $className[0] = strtoupper($className[0]); // первый символ класса должен быть в верхнем регистре.
                    $file = $path.$className.'.php';
//            echo $file."<br>";
                    if(file_exists($file)){
                        require_once($file);
                    }
                }
            }
            else{
                throw new Exception($className.' - this file does not exist.');
            }
        });
    }
}

?>