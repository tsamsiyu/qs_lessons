<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class TestExt{
    public static function test(){
        echo "I'm test extension";
    }
}