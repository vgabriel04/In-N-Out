<?php

class Model
{
    protected static $tableName= '';
    protected static $columns = [];
    protected $values = [];
    
    //o construct obriga que, quando a classe for instanciada, seja passado o parametro $arr; já o paramentro $arr consiste em informar uma chave e um valor
    function __construct($arr)
    {
        $this->loadFromArray($arr);
    }

    public function loadFromArray($arr){
        if($arr){
            foreach($arr as $key => $value){
                $this->$key = $value;
            }
        }
    }

    public function __get($key){
        return $this->values[$key];
    }

    public function __set($key, $value){
        $this->values[$key] = $value;
    }

    public static function getOne($filters = [], $columns = '*'){
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);        
        return $result ? new $class($result->fetch(PDO::FETCH_ASSOC)) : null;
    }

    public static function get($filters = [], $columns = '*'){
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $columns);
        if($result){
            $class = get_called_class();
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                array_push($objects, new $class($row) );
            }
        }
        return $objects;
    } 
    
    public static function getResultSetFromSelect($filters = [], $columns = '*'){
        $sql = "select ${columns} from". static::$tableName . static::getFilters($filters);
        $statement = Database::getResultFromQuery($sql);
        if($statement->rowCount() === 0){
            return null;
        } else{
            return $statement;
        }
    }

    private static function getFilters($filters){
        $sql = '';
        if(count($filters) > 0){
            $sql .= "where 1 = 1";
            foreach($filters as $column => $value){
                $sql .= " and ${column} = " . static::getFormatedValue($value);
            }
        }
        return $sql;
    }

    private static function getFormatedValue($value){
        if(is_null($value)){
            return "null";
        } elseif (gettype($value) === 'string'){
            return "'${value}'";
        } else{
            return $value;
        }
    }


}
