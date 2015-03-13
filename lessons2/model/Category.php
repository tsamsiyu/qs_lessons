<?php

class Category extends ActiveRecord{
    public function fields(){
        return array('id', 'name',);
    }

    public function rules(){ // на данный момент нужно для правильного запроса по типам в бд
        return array(
            array(array('name',), 'string'),
            array(array('id',), 'numeric'),
        );
    }

    public function relations(){ // на данный момент нужно лишь для того, что бы знать названия полей при массовом присваивании
        return array();
    }

    public static function getTableName(){
        return "tr_category";
    }

}