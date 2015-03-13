<?php

class ItemController{
    public function actionTask1(){ // test findAll
        $item = new Item();
        $model = $item->findAll();

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'findAll from Item'));
    }

    public function actionTask2(){ // test findByPk
        $item = new Item();
        $model = $item->findByPk($_GET['item_pk']);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'findByPk {'.$_GET['item_pk'].'} from Item'));
    }

    public function actionTask3(){ // test create
//        Trivia::pr($_POST);
        $category = new Category();
        $category = $category->findAll();

        if($_POST["item_submit"]){
            $item = new Item();
            $item->assignment('item_'); // функция для присваивания аттрибутов модели, параметр - префикс name-а формы
            if($item->validate()){ // на данный момент пустая функция
                $item->save(); // сохраняем и делаем редирект, чтобы удалить данные из пост
                App::getInstance("UrlManager")->redirect(App::getInstance("UrlManager")->getUrl);
                die();
            }
        }

        App::getInstance('View')->display('item/form',array('category'=>$category));
    }

    public function actionTask4(){ // test update
        $item = new Item();
        $model = $item->findAll();

        if($_POST["item_submit"]){
            $item = new Item();
            $item->assignment('item_'); // функция для присваивания аттрибутов модели, параметр - префикс name-а формы
            if($item->validate()){ // на данный момент пустая функция
//                echo "validate!";
                $item->save(); // сохраняем и делаем редирект, чтобы удалить данные из пост
                App::getInstance("UrlManager")->redirect(App::getInstance("UrlManager")->getUrl);
                die();
            }
        }

        if($_GET['update']){
            $item = new Item();
            $item = $item->findByPk((int)($_GET['update']));
            $category = new Category();
            $category = $category->findAll();
            App::getInstance('View')->display('item/form',array('item'=>$item[0], 'category'=>$category));
            die();
        }

        App::getInstance('View')->display('item/list',array('model'=>$model));
    }

    public function actionTask5(){
        $item = new Item();
        if(isset($_GET['name'])){
            $model = $item->findByName($_GET['name']);
        }
        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Тест функции findBy{name} из таблицы Item'));
    }


}