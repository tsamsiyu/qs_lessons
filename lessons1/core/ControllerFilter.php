<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

// класс для проверки работы с событиями
class ControllerFilter{
    public $var = 0;

    public function check(){
        if($_GET['c']){
            Event::trigger('check', array('val'=>0));
        }
    }
}