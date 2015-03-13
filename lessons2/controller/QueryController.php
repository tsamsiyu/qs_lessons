<?php

class QueryController{
    public function actionTask1(){
        $item = new Item();
        $var = $_GET['var'] or 0;
        $query = "SELECT name, price FROM ".$item->getTableName()." WHERE price < ".$var;
        $model = $item->findAll($query);

//        $item->treatment("id < 10, name>'c',price!=140, description >=pararam,  date=string create forever morever,category_id<='crithuit asd sdkfj'"); -- проверка функции обработки данных.

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Цены меньше, чем заданное число(в гет-парметре)', 'query'=>$query));
    }

    public function actionTask2(){
        $item = new Item();
        $var = $_GET['var'] or "";
        $query = "SELECT name, price FROM ".$item->getTableName()." WHERE price > ".$var;
        $model = $item->findAll($query);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Цены больше, чем заданное число(в гет-парметре)', 'query'=>$query));
    }

    public function actionTask3(){
        $item = new Item();
        $var = $_GET['str'] or "";
        $query = "SELECT name FROM ".$item->getTableName()." WHERE name LIKE '%".Trivia::stripBoundaryQuotes($var)."%'";
        $model = $item->findAll($query);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Имя содержит строку, оператор like (строка передается в гет-параметр)', 'query'=>$query));
    }

    public function actionTask4(){
        $item = new Item();
        $query = "SELECT name FROM ".$item->getTableName()." ORDER BY name";
        $model = $item->findAll($query);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Сортировка по имени', 'query'=>$query));
    }

    public function actionTask5(){
        $item = new Item();
        // 2 варианта запроса:
        $query ="SELECT i.name, c.name FROM ".Item::getTableName()." i, ".Category::getTableName()." c "." WHERE i.category_id = c.id";
//        $query = "SELECT i.name, c.name FROM ".Item::getTableName()." i "." INNER JOIN ".Category::getTableName()." c ON i.category_id = c.id";
        $model = $item->findAll($query, PDO::FETCH_NUM);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Реляционный запрос, выбор наименований категорий', 'query'=>$query));
    }

    public function actionTask6(){
        $item = new Item();
        $query = "SELECT COUNT(i.name), c.name FROM ".Item::getTableName()." i, ".Category::getTableName()." c "." WHERE i.category_id = c.id GROUP BY c.name";
        $model = $item->findAll($query, PDO::FETCH_NUM);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Выбор количества подкатегорий', 'query'=>$query));
    }

    public function actionTask7(){
        $item = new Item();
        $query = "SELECT SUM(i.price), c.name FROM ".Item::getTableName()." i, ".Category::getTableName()." c "." WHERE i.category_id = c.id GROUP BY c.name";
        $model = $item->findAll($query, PDO::FETCH_NUM);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Суммарная цена продуктов категорий', 'query'=>$query));
    }

    public function actionTask8(){
        $item = new Item();
        $query = "SELECT AVG(i.price), c.name FROM ".Item::getTableName()." i, ".Category::getTableName()." c "." WHERE i.category_id = c.id GROUP BY c.name";
        $model = $item->findAll($query, PDO::FETCH_NUM);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Средняя цена продуктов категорий', 'query'=>$query));
    }

    public function actionTask9(){
        $item = new Item();
        $query = "SELECT c.name FROM ".Item::getTableName()." i, ".Category::getTableName()." c "." WHERE i.category_id = c.id GROUP BY c.name HAVING COUNT(i.name) > 1";
        $model = $item->findAll($query, PDO::FETCH_NUM);

        App::getInstance('View')->display('index',array('model'=>$model, 'tittle'=>'Категории у которых не менее 2х подкатегорий', 'query'=>$query));
    }

}