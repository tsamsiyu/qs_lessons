<?php 
// Точка входа
    define("KEY_ACCESS", TRUE); // пользователь должен иметь доступ к файлам, объявленным после этой константы
//  компоненты ядра загружаем самостоятельно
	require_once('config/constant.php'); // Предопределенные константы
	require_once('core/Autoloader.php'); // Автозагрузка всех классов, кроме ядра
	require_once('core/App.php'); // Основной класс приложения, фабрика остальных классов.
	require_once('core/Router.php'); // Класс, вызывающий нужное действие в ответ на GET-параметр route.
	require_once('core/UrlManager.php'); // Класс, содержащий url-параметры
    require_once('core/View.php'); // Клаcс, отвечающий за вывод нужного отображения.
    require_once('core/Event.php'); // класс, содержащий callback-функцию
    require_once('core/ControllerFilter.php'); // Класс содержащий фильтр, нужный для теста callback-функции
    require_once('extension/events.php'); // здесь будем хранить наши события.
    require_once('core/DataBase.php'); // Класс связи с базой данных
    require_once('core/ActiveRecord.php'); // Класс-помощник для работы с бд

    Autoloader::init();
    DataBase::connect();

    $Router = App::getInstance('Router');

    $UrlManager = App::getInstance('UrlManager');

    $Filter = App::getInstance('ControllerFilter');
    $Filter->check(); // Callback определена в файле extension/events.php

    $View = App::getInstance('View');

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
    $triv->var = 10; // var переменную уже убрал
    echo $triv2->var;
 */

 ?>