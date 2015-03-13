<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class UrlManager{
    private $host;
    private $param;
    private $path;
    private $root;
    private $url;

    public function __construct(){
        $this->host = $_SERVER['SERVER_NAME'];
        $this->param = $_SERVER['QUERY_STRING'];
        $this->path = $_SERVER['PHP_SELF'];
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->url = $this->host.'/'.$this->path.'?'.$this->param;
    }

    public function getHost(){
        return $this->host;
    }

    public function getParam(){
        return $this->param;
    }

    public function getPath(){
        return $this->path;
    }

    public function getRoot(){
        return $this->root;
    }

    public function getUrl(){
        return $this->url;
    }

    public function link($route=""){ // функция создания роута из вида controller/action
        if($route)
            return '?r='.$route;
        else
            return "?r=test/index";
    }

    public function redirect($route=""){ // редирект
        $route = $this->link($route);
        header('Refresh: 0; '.$route);
    }
}