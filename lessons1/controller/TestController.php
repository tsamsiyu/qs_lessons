<?php

defined('KEY_ACCESS') or die('ACCESS DENIED'); // запрещаем запуск файла до объявления константы

class TestController{
    public static function test(){
        echo "I'm test controller<br>";
    }

    public function actionIndex(){
        $model = new TestModel();
        App::getInstance('View')->display('index',array('model'=>$model));
    }

    public function actionAbout(){
        App::getInstance('View')->display('help/about');
    }

    public function actionManual(){
        App::getInstance('View')->display('help/manual');
    }

    public function actionCompany(){
        App::getInstance('View')->display('info/company');
    }

    public function actionTerms(){
        if(Event::trigger('resolution', array('variable'=>rand(0,100)))){
            Trivia::alert('Вызвана callback функция');
        }
        App::getInstance('View')->display('info/terms');
    }
}