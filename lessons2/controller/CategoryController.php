<?php

class CategoryController{
    public function actionTask1(){
        $model = new Category();
        $model = $model->findAll();

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'findAll from Category'));
    }

    public function actionTask2(){
        $model = new Category();

        $model = $model->findByPk($_GET['category_pk']);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'findByPk {'.$_GET['category_pk'].'} from Category'));
    }

    public function actionTask3(){
        $category = new Category();

        if($_GET['update']){
            if(is_numeric($_GET['update'])){

            }else{
                throw new Exception();
            }
        }

        if($_POST["category_submit"]){
            $category->assignment('category_'); // функция для присваивания аттрибутов модели, параметр - префикс name-а формы
            if($category->validate()){ // на данный момент пустая функция
                $category->save(); // сохраняем и делаем редирект, чтобы удалить данные из пост
                App::getInstance("UrlManager")->redirect(App::getInstance("UrlManager")->getUrl);
            }
        }
        App::getInstance('View')->display('category/form',array());
    }

    public function actionTask4(){ // test update
        $category = new Category();
        $model = $category->findAll();

        if($_POST["category_submit"]){
            $category = new Category();
            $category->assignment('category_'); // функция для присваивания аттрибутов модели, параметр - префикс name-а формы
            if($category->validate()){ // на данный момент пустая функция
//                echo "validate!";
                $category->save(); // сохраняем и делаем редирект, чтобы удалить данные из пост
                App::getInstance("UrlManager")->redirect(App::getInstance("UrlManager")->getUrl);
                die();
            }
        }

        if($_GET['update']){
            $category = new Category();
            $category = $category->findByPk((int)($_GET['update']));
            App::getInstance('View')->display('category/form',array('category'=>$category[0]));
            die();
        }

        App::getInstance('View')->display('category/list',array('model'=>$model));
    }

    public function actionTask5(){
        $item = new Category();
        if(isset($_GET['name'])){
            $model = $item->findByName($_GET['name']);
        }
        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Тест функции findBy{name} из таблицы Category'));
    }

}