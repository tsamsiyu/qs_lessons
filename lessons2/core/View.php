<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class View{
    public $test = 0;
    public function display($view="", $param=array(), $all=true ){
        // получаем нужный вид из контроллера и формируем  пути для включения отображения
        extract($param, EXTR_OVERWRITE); // переводим поля массива в переменные
        $content = PAGE.$view.'.php';
        if(!$all){
            include($content);
            return 1;
        }
        $header = LAYOUT.'header.php';
        $footer = LAYOUT.'footer.php';
        $menu = LAYOUT.'menu.php';
        include(LAYOUT.'wrap.php');

        return 1;
    }
}