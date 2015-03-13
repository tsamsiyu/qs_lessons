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
            'host'=>'mysql.qs.quart-soft.com',
            'db_name'=>'tsamsiyu_training',
            'password'=>'admin4mysql',
            'login'=>'devel',
            'prefix_table'=>'tr_',
        )
    ),
);