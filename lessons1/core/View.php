<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class View{
    public $test = 0;
    public function display($view="", $param=array() ){
        // получаем нужный вид из контроллера и формируем  пути для включения отображения
        $model = $param['model'];
        $header = LAYOUT.'header.php';
        $footer = LAYOUT.'footer.php';
        $menu = LAYOUT.'menu.php';
        $content = PAGE.$view.'.php';
        include(LAYOUT.'wrap.php');
        return 1;
    }
}