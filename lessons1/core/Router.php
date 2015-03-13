<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class Router{
    private $rout;
    private $controller;
    private $action;
    private $module;

    public function __construct(){
        if($_GET['r']){ // если роут есть - получаем названия контроллера и метода, иначе - загружаем домашнюю страницу.
            $this->rout = $_GET['r'];
            $routArr = explode('/', $this->rout);
            if(count($routArr) == 2){
                $this->controller =  $routArr[0];
                $this->action = $routArr[1];
            }elseif(count($routArr) == 3){
                $this->module = $routArr[0];
                $this->controller =  $routArr[1];
                $this->action = $routArr[2];
            }

//            echo $this->controller."  -  ".$this->action.'<br>'; // переданные параметры action и controller;

            $controller = $this->controller;
            $controller[0] = strtoupper($controller[0]);
            $controller = $controller."Controller";

            $action = $this->action;
            $action[0] = strtoupper($action[0]);
            $action = 'action'.$action;
// если полученные GET-параметром данные не соответствуют существющему контроллеру и его методу, то перенаправляем на главную страницу
            if(class_exists($controller) && method_exists($controller, $action)){
                App::getInstance($controller)->$action();
            }else{
                App::getInstance('TestController')->actionIndex();
            }
        }else{
            App::getInstance('TestController')->actionIndex();
        }
    }

    public function getController(){
        return $this->controller;
    }

    public function getRout(){
        return $this->rout;
    }

    public function getAction(){
        return $this->action;
    }
}