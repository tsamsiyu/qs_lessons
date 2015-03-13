<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class TestModel extends ActiveRecord{
    public static function test(){
        echo "I'm test model<br>";
    }
}