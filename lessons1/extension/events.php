<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

// callback фукнция реагирующая на GET-параметр 'c' (задание 10)
event::bind('check', function($args = array()){
    $check = $_GET['c'];
    if(is_numeric($check)){
        if($check > $args['val']){
            Trivia::alert('Call event check, result: +');
        }else{
            Trivia::alert('Call event check, result: -');
        }
    }
});

// Пример callback фукнции для получания разрешения (задание 9)
event::bind('resolution', function($args = array()){
    if($args['variable'] % 2 == 0){
        return false;
    }
    else{
        return true;
    }
});