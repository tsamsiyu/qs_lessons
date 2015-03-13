<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

// класс реаилзующий возможность создавать/перезаписывать события и записывать их в переменную класса
class Event{
    public static $events = array();

    public static function trigger($event, $args = array())
    {
        if(isset(self::$events[$event]))
        {
            foreach(self::$events[$event] as $func)
            {
                return call_user_func($func, $args);
            }
        }
    }

    public static function bind($event, Closure $func)
    {
        self::$events[$event][] = $func;
    }
}