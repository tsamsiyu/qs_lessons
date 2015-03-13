<?php

class DataBase{
    private $connection;
    public function __construct(){
        if(file_exists(CONFIG.'base.php')){
            $config = require(CONFIG.'base.php');
            $config = $config['db'];

            foreach($config as $bd){
                try{
                    switch($bd['type']){
                        case 'mssql':
                            $this->connection = new PDO("mssql:host='".$bd['host']."';dbname='".$bd['type']."'.", $bd['db_name'], $bd['password']);
                            break;
                        case 'sybase':
                            $this->connection = new PDO("sybase:host='".$bd['host']."';dbname='".$bd['type']."'.", $bd['db_name'], $bd['password']);
                            break;
                        case 'mysql':
                            $this->connection = new PDO("mysql:host='".$bd['host']."';dbname='".$bd['type']."'.", $bd['db_name'], $bd['password']);
                            break;
                        case 'sql':
                            $this->connection = new PDO("sqlite:my/database/path/database.db");
                            break;
                        default:
                            throw new Exception("This database does not exist.");
                    }
                }catch(PDOException $e){
                    echo("Connect to Db error: ".$e->getMessage());
                }
            }
        }
    }
}