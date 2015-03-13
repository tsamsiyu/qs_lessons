<?php

// не используемый файл

$query = false; // сюда составим наш запрос

if(is_string($sql)){ // если передали строку - это стркоа sql запрос, иначе составляем запрос сами из отдельных параметров
    $query = $sql;
}else{
    $select = ($sql['select'])? "SELECT ".$sql['select'] :  "SELECT *";
    $from = ($sql['from'])? "FROM ".$sql['from'] : "FROM ".$name_table;

    if($sql['where']){
        if(isset($sql['where']['in'])){
            echo $sql['where']['in'];
            $field = $sql['where']['in']['field'];
            $value = $sql['where']['in']['value'];
            $value = $this->treatmentVal($field, $value);
            $where = "WHERE ".$field." IN (".$value.")";
        }else{
            if(is_string($sql['where'])){
                $where = "WHERE ".$sql['where'];
            }elseif(is_array($sql['where'])){
                $string = false; // соеденим сюда значения для поиска where
                foreach($sql['where'] as $key=>$val){
                    $string.= $key." = ".$val.", ";
                }
                $string = substr($string, 0, -2);
                $where = "WHERE ".$string;
            }
        }
    }else{
        $where = false;
    }

    if($sql['like']){
        $like = false;
        if(is_array($sql['like'])){
            $l = false; // сюда запишем все собранное услвоие LIKE
            foreach($sql['like'] as $key=>$row){
                $row = Trivia::stripBoundaryQuotes($row); // убираем кавычки по бокам, чтобы случайно не дублировать
                $l.=" ".$key." LIKE '%".$row."%', ";
            }
            $l = substr($l, 0, -2);
            if(!$where){ //  если условия where еще нет, значит нужно его создать
                $like.= " WHERE ".$l;
            }else{
                $like.= ", ".$l;
            }
        }
    }else{
        $like = false;
    }

    if($sql['order']){
        if(is_array($sql['order'])){
            $order = " ORDER BY ";
            foreach($sql['order'] as $key=>$row){
                $order.= $key." ".$row.", ";
            }
            $order = substr($order, 0, -2);
        }elseif(is_string($sql['order'])){
            $order = $sql['order'];
        }else{
            throw new Exception("Неправильный тип поля order");
        }
    }else{
        $order = false;
    }

    if($sql['join']){
        if(is_array($sql['join'])){
            $join = false;
            $type = ($sql['join']['type'])? $sql['join']['type'] : 'INNER JOIN';
            $table = $sql['join']['table'];
            $on = $sql['join']['on'];
            $join.= " ".$type." ".$table." ON ".$on;
            $query.= $join;
        }elseif(is_string($sql['join'])){
            $join = $sql['join'];
        }else{
            throw new Exception("Неправильный тип поля join");
        }
    }else{
        $join = false;
    }
}

$query.= $select." ".$from." ".$where;




////////////////////
/*
     * treatmentVal - обработка значений по которым идет поиск в бд. Используя методы модели fields и rules.
     * @param {string} - поле модели, которое обрабатывается. Нужно для того, чтобы узнать тип данных. Используются методы модели rules and fields.
     * @param {string or array} - значения, которые обрабатываются
     * @return - возвращает перечисленные через запятую значения нужного типа.
     */
public function treatmentVal($field, $value){
    if(!is_string($field)){
        throw new Exception("Название поля должно быть строкой.");
    }
    if(!in_array($field, $this->fields())){
        throw new Exception("Поля ".$field." в БД не существует или вы его не указали в fields");
    }
    $rules = $this->rules();
    if(!is_string($value)){
        $value = (string)$value;
    }
    if(is_string($value)){ // если значение строка - объеденяем ее в массив
        $value = Trivia::stripBoundaryQuotes($value);
        $value = explode(',', $value);
        foreach($value as $key=>$row){
            $value[$key] = trim($row); // если разделитель был не ',' а ', ' - нужно убрать лишние пробелы
        }
    }else{
        throw new Exception("Значение поля не может быть преобразовано в строку.");
    }

    $finalValue = ""; // запишем сюда обработанное значение по которому будет поиск в бд
    foreach($rules as $row){
        if($row[1] == 'string'){
            if(in_array($field, $row[0])){ // в зависимости от правила обрабатываем соответствующим образом
                // значит это поле - строка
                foreach($value as $row){
                    $finalValue.= "'".addslashes($row)."',";
                }
                $finalValue = substr($finalValue, 0, -1);
            }else{
                // иначе - число
                $finalValue = implode(',', $value);
                $finalValue = str_replace("'", "", $finalValue);
            }
        }
    }
//        Trivia::pr($finalValue);
    return $finalValue;
}