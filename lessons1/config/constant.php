<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

define('TITTLE', 'Lessons 1');

// --- Пути ---
define('HOME', $_SERVER['SERVER_NAME'].'/tsamsiyu/lessons1_1/'); // задаем домашнюю директорию
define('CORE', __DIR__.'/../core/' );
define('VIEW', __DIR__.'/../view/default_template/' ); // здесь можно задать шаблон для вывода сайта
define('PAGE', VIEW.'page/' );
define('CONTROLLER', __DIR__.'/../controller/' );
define('MODEL', __DIR__.'/../model/' );
define('CONFIG', __DIR__.'/');
define('HELPER', __DIR__.'/../helper/');
define('EXT', __DIR__.'/../extension/');
define('CSS', VIEW.'css/');
define('JS', VIEW.'js/');
define('IMG', VIEW.'image/');
define('LAYOUT', VIEW.'/layout/');
// -------

 ?>