<?php 
// Точка входа
    define("KEY_ACCESS", TRUE); // пользователь должен иметь доступ к файлам, объявленным после этой константы
//  загружаем компоненты ядра
	require_once('config/constant.php'); // Предопределенные константы
	require_once('core/Autoloader.php'); // Автозагрузка всех классов, кроме ядра
	require_once('core/App.php'); // Основной класс приложения, фабрика остальных классов.
	require_once('core/Router.php'); // Класс, вызывающий нужное действие в ответ на GET-параметр route.
	require_once('core/UrlManager.php'); // Класс, содержащий url-параметры
    require_once('core/View.php'); // Клаcс, отвечающий за вывод нужного отображения.
    require_once('core/Event.php'); // класс, содержащий callback-функцию
    require_once('core/ControllerFilter.php'); // Класс содержащий фильтр, нужный для теста callback-функции
    require_once(EXT.'events.php'); // здесь будем хранить наши события.
    require_once('core/DataBase.php'); // Класс связи с базой данных

    Autoloader::init();

    $View = App::getInstance('View');

    $Router = App::getInstance('Router');

    $UrlManager = App::getInstance('UrlManager');

    $Filter = App::getInstance('ControllerFilter');
    $Filter->check(); // Callback определена в файле extension/events.php

    $DB = App::getInstance('DataBase');

/*
//  проверка класса App(fabric + singleton)
    $app = App::getInstance();
    $app = App::getInstance();
    $app = App::getInstance();
    $triv = App::getInstance('Trivia');
    $triv = App::getInstance('Trivia');
    $triv = App::getInstance('Trivia');
    echo "<hr>";
    $triv2 = App::getInstance('Trivia');
    $triv->var = 10;
    echo $triv2->var;
 */

// проверка автозагрузчика классов.
//    Trivia::alert("test");

 ?>