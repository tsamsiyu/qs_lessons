<?php

// Класс для соединения с базой и хранения экземпляра этого соединения

/*
 *
 * item.category_id(n) ---- category.id(1)
 * ON_MANY                  TO_MANY
 *
 * item.category_id(1) ---- category.id(1)
 * ON_ONE                   TO_ONE
 *
 * item.category_id(n) --- category.id(n)
 * MANY_MANY                MANY_MANY
 *
 * relations:   ON_MANY,
 *              TO_MANY,
 *              ON_ONE,
 *              TO_ONE,
 *              MANY_MANY
 */

class DataBase{
    private static $handle; //TODO: изменить на массив для использования нескольких БД
    public static $prefix;
    public static $nameBase;

    public static $ON_MANY = 'on_many';
    public static $TO_MANY = 'to_many';
    public static $ON_ONE = 'on_one';
    public static $TO_ONE = 'to_one';
    public static $MANY_MANY = 'many_many';

    private function __construct(){}

    public static function connect(){
        if(file_exists(CONFIG.'base.php')){
            $config = require(CONFIG.'base.php');
            $config = $config['db'];

            foreach($config as $bd){
                $name =  $bd['db_name'];
                $host = $bd['host'];
                $type = $bd['type'];
                $login = $bd['login'];
                $pass = $bd['password'];
                self::$prefix = $bd['prefix_table'];
                self::$nameBase = $name;

                try{
                    switch($bd['type']){
                        case 'sqlite':
                            sefl::$handle = new PDO("sqlite:my/database/path/database.db"); // свои настройки
                            break;
                        default:
                            self::$handle = new PDO("$type:host=$host;dbname=$name", $login, $pass);
                    }
                }catch(PDOException $e){
                    echo("Connect to Db error: ".$e->getMessage()."<br>");
                }
            }
        }
    }

    public static function getHandle(){
        return self::$handle;
    }

    public static function disconnection(){
        if(self::$handle){
            self::$handle = null;
        }else{
            throw new Exception("There is no connection.");
        }
    }

    public static function getNameDb(){
        return self::$nameBase;
    }
}