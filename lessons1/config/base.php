<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

return array(
    'router'=>array(
        HELPER,
        EXT,
//        '../helper/' // - правильный формат
    ),
    'db'=>array(
        array(
            'type'=>'mysql',
            'password'=>'',
            'login'=>'root',
            'host'=>'localhost',
            'db_name'=>'test',
        ),
    ),
);