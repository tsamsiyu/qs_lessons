<?php

class ActiveRecord extends DataBase{
    private $table_id = false;

    public function __construct(){}

    public function findAll($sql = false, $assoc = false){ // Имя вызывающего класса должно совпадать с именем модели, с которой выбираются данные.
        $handle = DataBase::getHandle();
        $classname = get_class($this);
        $name_table = $classname::getTableName();
        $query = ($sql)? $sql : "SELECT * FROM ".$name_table;
//        echo $query;
        $record = $handle->query($query)->fetchAll(($assoc)?  : PDO::FETCH_ASSOC);
        return $record;
    }

    /*
     * findbyPk - поиск по переданному значению первичного ключа
     * @id {string or numeric or array} - значения по которому/которым будет идти поиск
     */
    public function findByPk($id, $assoc=true){
        if(is_string($id)){
            $id = explode(",", $id);
        }
        $string_id = $this->treatment('id', $id); // обрабатываем данные
        $handle = DataBase::getHandle();
        $classname = get_class($this); $name_table = $classname::getTableName();
        $query = "SELECT * FROM ".$name_table." WHERE id in(".$string_id.")";
//        echo $query;
        $record = $handle->query($query)->fetchAll(($assoc)? PDO::FETCH_ASSOC:PDO::FETCH_BOTH);

        return $record;
    }

    /*
     * save - если id установлен - обновление по этому id, иначе - создание новой записи
     * @return - результат созадния/обновления
     */
    public function save(){
        $fields =  get_class_vars(get_called_class());
        $id = $this->getPrimaryKey();
        if(isset($id)){ // если первичного ключ в данной таблице есть сохраняем или обновляем, иначе - ошибка
            $param = array();
            foreach($this->fields() as $row){ // забираем параметры модели
                if($this->$row){
                    $param[$row] = $this->$row;
                }
            }
//            Trivia::pr($param);
            if(isset($this->$id)){
//                echo "update";
                return $this->update($param);
            }else{
//                echo "create";
                return $this->create($param);
            }
        }else{
            throw new Exception('В данной таблице не найден первичный ключ');
        }
    }

    /*
     * update - обновление записи в бд
     * @param $param {array} - массив, где ключ - название поля, а значение ключа - значение этого поля, которое запишется в бд
     */
    public function update($param=array()){
        $handle = DataBase::getHandle();
        $classname = get_class($this); $name_table = $classname::getTableName();
        $param_str = $this->treatmentKeyVal($param);
        $record = $handle->query("UPDATE ".$name_table." SET ".$param_str." WHERE ".$this->getPrimaryKey()." = ".$param[$this->getPrimaryKey()]);
//        Trivia::pr($record);

        $id = $this->getPrimaryKey();
        $this->$id = null; // т.к. это признак действия удалитьИЛИобновить нужно его занулить

        if($record){
            return true;
        }else{
            return false;
        }
    }

    /*
     * create - создание новой записи в бд
     * @param $param {array} - массив, где ключ - название поля, а значение ключа - значение этого поля, которое запишется в бд
     */
    public function create($param=array()){
        $handle = DataBase::getHandle();
        $classname = get_class($this); $name_table = $classname::getTableName();
        $rowTable = "";
        $valueTable = "";
        foreach($param as $key=>$row){
            if($key != $this->getPrimaryKey()){
                $rowTable.= $key.", ";
                if(is_string($row)){
                    $valueTable.= '"'.addslashes($row).'", ';
                }else{
                    $valueTable.= $row.', ';
                }
            }
        }
        $rowTable = substr($rowTable, 0, -2); // удаляем лишний пробел и запятую на конце
        $valueTable = substr($valueTable, 0, -2); // удаляем лишний пробел и запятую на конце

        $record = $handle->query("INSERT INTO ".$name_table ." (".$rowTable.") VALUES(".$valueTable.")");
        if($record){
            return true;
        }else{
            return false;
        }
    }

    /*
     * getPrimaryKey - возвращает название первичного ключа таблицы в бд
     */
    public function getPrimaryKey(){
        if(!($this->table_id)){
            $handle = DataBase::getHandle();
            $classname = get_class($this); $name_table = $classname::getTableName();
            $record = $handle->query("SHOW KEYS FROM ".$name_table." WHERE Key_name = 'PRIMARY'")->fetchAll(PDO::FETCH_ASSOC);
            $this->table_id = $record[0]['Column_name'];
        }
        return $this->table_id;
    }

    public function __call($name, $value){
        $assoc = $value['assoc'];
        $fields = $this->fields(); // поля модели
        $searchRow = false; // элемент по которому будет идти поиск. findBy{элемент}
        $beginName = substr($name, 0, 6); // первые 6 символов - начало названия метода (findBy)
        $endName = substr($name, 6); // все после 6 символа - это название поискового поля (с неправильным регистром)
        $value = $value[0]; // значения поля поиска
        if(strtolower($beginName) == 'findby'){ // если начало названия метода правильное - идем дальше, иначе ошибка
            foreach($fields as $row){
                if(strtolower($row) == strtolower($endName)){ // проверяем существует ли данное поле в модели и записываем его название в searchRow уже с учетом правильного регистра
                    $searchRow = $row;
                    break;
                }
            }
            $value = explode(',', $value);
            $searchVal = $this->treatment($searchRow, $value);
//            echo $searchVal; // TODO: исправить
            $handle = DataBase::getHandle();
            $classname = get_class($this); $name_table = $classname::getTableName();
            $query = "SELECT * FROM ".$name_table." WHERE ".$searchRow." in(".$searchVal.")";
//            echo $query;
            $record = $handle->query($query)->fetchAll(($assoc)? $assoc : PDO::FETCH_ASSOC);
            return $record;
        }else{
            throw new Exception("Such a method does not exist");
        }
    }

    public function validate(){
        return true;
    }

    /*
     * assignment - присваивает данные из поста данной модели
     * @param prefix {string} префикс дописанный в форме к модели, пр.: <input name="pre_data" /> -здесь data - аттрибут модели, а pre - префикс, который нужно знать, чтобы убрать
     */
    public function assignment($prefix=""){
        $fields_input = array(); // сюда записываем переданные поля
        foreach($_POST as $key=>$row){ // проходим по Посту в поиске полей формы
            if(stripos($row, $prefix) == 0){
                $fields = $this->fields(); // узнаем имеющиеся поля чтобы сравнивать
                $relat = $this->relations(); // узнаем название связей также чтобы сравнивать
                $keyWithoutPrefix = substr($key, strlen($prefix)); // ищем ключ без префикса для сравнения
                if(in_array($keyWithoutPrefix, $fields)){ // ищем этот ключ в полях данной модели, если такой есть - добавляем
//                    echo $keyWithoutPrefix."<br>";
                    $fields_input[$keyWithoutPrefix] = $row;
                }
                if(count($relat) > 0){
                    if(array_key_exists($keyWithoutPrefix, $relat)){
//                    echo $relat[$keyWithoutPrefix];
                        $fields_input[$relat[$keyWithoutPrefix]] = $row;
                    }
                }
            }
        }
//        Trivia::pr($fields_input);
        foreach($fields_input as $key=>$row){ // найденные поля присваиваем модели
            if($key == $this->getPrimaryKey()){
                if(!($this->checkId($row))){
                    throw new Exception("Нет такого id");
                }
            }
            $this->$key = $row;
        }
        return true;
    }

   /*
    * availabilty - возвращает количество найденных по услвию WHERE $field in ($value)
    * @param $field {string} - название поискового поля
    * @param $value {string or array} - значения поля #field.
    */
    public function availabilty($field, $value){
        if(is_string($value)){
            $value = explode(',', $value);
        }
        $value = $this->treatment($field, $value); // обрабатываем входное значение
        $handle = DataBase::getHandle();
        $classname = get_class($this); $name_table = $classname::getTableName();
        $query = "SELECT COUNT(*) FROM ".$name_table." WHERE ".$field." in (".$value.")";
        $record = $handle->query($query)->fetch(PDO::FETCH_NUM);

        return $record;
    }

    public function checkId($id){
        if(is_numeric($_GET['update'])){ // проверяем на число, т.к. обновлять можно лишь одну запись одновременно.
            $countIsId = $this->availabilty('id', $_GET['update']);
            if($countIsId[0] == 1){ // если такой id в базе один, то все хорошо - можно запрашивать данные для обновления.
                return true;
            }else{
                throw new Exception('Такого id нет в базе');
            }
        }else{
            throw new Exception('Посланный id не является числом');
        }
    }

    /*
     * treatment - обработка значений в соответствии к их типам, указанным в rules. Также проверяется наличие передаваемого поля в методе модели fields
     * @param $field {string} - либо название поля, либо строка арифмитического типа: id < 10, name >= "C", description != "good"
     * @param $value {array} - если field название поля модели, то в value передаем массив значений к этой модели, а если арифметическое выражение - то оно не используется
     * @return - обработанное значение
     */
    public function treatment($field, $value=false){
        if(is_string($field)){
            $fields = $this->fields();
            $field = Trivia::stripBoundaryQuotes($field);
            if(!in_array($field, $fields)){
                // такого поля в базе нет, пробуем проверять на арифмитеческие выражение
                $expr = explode(',', $field);
                $expr_split = array(); // массив разбитый на оператор и его операнды
                foreach($expr as $key=>$row){
                    array_push($expr_split, Trivia::splitOnOperator(trim($row)));
                }
//                Trivia::pr($expr_split);
                $result = false;
                foreach($expr_split as $row){
                    $row['begin'] = str_replace("'", "", $row['begin']);
                    if(!in_array($row['begin'], $fields)){
                        throw new Exception("Проверте правильность выражения, значение ".$row['begin']." среди полей модели не найдено");
                    }

                    $rules = $this->rules();
                    foreach($rules as $rule){
                        if($rule[1] == 'numeric'){
                            if(in_array($row['begin'], $rule[0])){
                                // значит тип поля - число
                                if(!is_numeric($row['end'])){
                                    throw new Exception("Значения поля ".$row['begin']." должны быть чилами.");
                                }
                                $result.= $row['begin']." ".$row['separator']." ".Trivia::stripBoundaryQuotes($row['end']).", ";
                                break;
                            }else{
                                // иначе тип поля - строка
                                if(!is_string((string)$row['end'])){
                                    throw new Exception("Значения поля ".$row['begin']." должны быть строками.");
                                }
                                $result.= $row['begin']." ".$row['separator']." '".addslashes(Trivia::stripBoundaryQuotes($row['end']))."', ";
                                break;
                            }
                        }
                    }
                }
                $result = substr($result, 0, -2);
                return $result;
            }else{
                // поле в базе есть, значит проверяем значения
                if(!is_array($value)){
                    throw new Exception("Если первый аргумент является полем таблицы, значения должны быть переданы в массиве.");
                }
                $result = false;
                $rules = $this->rules();
                foreach($rules as $rule){
                    if($rule[1] == 'numeric'){
                        if(in_array($field, $rule[0])){
                            // значит числа
                            foreach($value as $row){
                                $row = str_replace("'", "", $row);
                                if(!is_numeric($row)){
                                    throw new Exception("Значения поля ".$field." должны быть числами.");
                                }
                                $result.= $row.", ";
                            }
                            $result = substr($result, 0, -2);
                            return $result;
                        }else{
                            // иначе - строки
                            foreach($value as $row){
                                if(!is_string((string)$row)){
                                    throw new Exception("Значения поля ".$field." должны быть строкой.");
                                }
                                $result.= "'".addslashes(Trivia::stripBoundaryQuotes($row))."', ";
                            }
                            $result = substr($result, 0, -2);
                            return $result;
                        }
                    }
                }
            }
        }else{
            throw new Exception("Первый аргумент должен быть либо названием поля либо строкой типа id < 10, name > 'C'");
        }
    }

}

// TODO: перечислить все функции для обработки данных пришедшых от пользователя