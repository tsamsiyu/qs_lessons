<?php

class Item extends ActiveRecord{

    public function fields(){
        return array('id', 'name', 'price', 'date', 'description', 'category_id');
    }

    public function rules(){ // на данный момент нужно для правильного запроса по типам в бд
        return array(
            array(array('name', 'description', 'date'), 'string'),
            array(array('id', 'category_id', 'price'), 'numeric'),
            array(array('name', 'description', 'date', 'price', 'category_id'), 'required'), // не используется
        );
    }

    public function relations(){ // на данный момент нужно лишь для того, что бы знать названия полей при массовом присваивании
        return array('category'=>array('category_id', 'has_many', 'Category')); // констант связей пока не назначал
    }

    public static function getTableName(){
        return "tr_item";
    }

}