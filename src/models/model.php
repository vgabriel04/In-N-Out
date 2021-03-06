<?php

class Model
{
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];

    function __construct($arr, $sanitize = true)
    {
        $this->loadFromArray($arr, $sanitize);
    }

    public function loadFromArray($arr, $sanitize = true) {
        if($arr) {
            foreach($arr as $key => $value) {
                $cleanValue = $value;
                if($sanitize && isset($cleanValue)) {
                    $cleanValue = strip_tags(trim($cleanValue));
                    $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                }
                $this->$key = $cleanValue;
            }
        }
    }

    public function __get($key)
    {
        if (!isset($this->values[$key])) {
            return null;
        }
        return $this->values[$key];
    }

    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function getValues() {
        return $this->values;
    }

    public static function getOne($filters = [], $columns = '*')
    {
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);
        return $result ? new $class($result->fetch(PDO::FETCH_ASSOC)) : null;
    }

    public static function get($filters = [], $columns = '*')
    {
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $columns);
        if ($result) {
            $class = get_called_class();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                array_push($objects, new $class($row));
            }
        }
        return $objects;
    }

    public static function getResultSetFromSelect($filters = [], $columns = '*')
    {
        $sql = "select ${columns} from " . static::$tableName . " " . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);
        if ($result->rowCount() === 0) {
            return null;
        } else {
            return $result;
        }
    }

    public function insert()
    {
        //removo a coluna id da lista de colunas para n??o considerar no insert
        $colunas =  static::$columns;
        foreach ($colunas as $key => $coluna) {
            if ($coluna == 'id') {
                unset($colunas[$key]);
            }
        }
        $sql = "INSERT INTO " . static::$tableName . " (" . implode(",", $colunas) . ") VALUES (";
        foreach ($colunas as $col) {

            $sql .= static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ')';
        $id = Database::executeSQL($sql);
        $this->id = $id;
    }

    public function update()
    {
        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach (static::$columns as $col) {
            $sql .= " ${col} = " . static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id = {$this->id}";
        Database::executeSQL($sql);
    }

    public static function getCount($filters = [])
    {
        $result = static::getResultSetFromSelect(
            $filters,
            'count(*) as count'
        );
        return $result->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function delete() {
        static::deleteById($this->id);
    }

    public static function deleteById($id) {
        $sql = "DELETE FROM " . static::$tableName . " WHERE id = {$id}";
        Database::executeSQL($sql);
    }

    private static function getFilters($filters)
    {
        $sql = '';
        if (count($filters) > 0) {
            $sql .= " WHERE 1 = 1";
            foreach ($filters as $column => $value) {
                if ($column == 'raw') {
                    $sql .= " AND {$value}";
                } else {
                    $sql .= " AND ${column} = " . static::getFormatedValue($value);
                }
            }
        }
        return $sql;
    }

    private static function getFormatedValue($value)
    {
        if (is_null($value)) {
            return "null";
        } elseif (gettype($value) === 'string') {
            return "'${value}'";
        } elseif (gettype($value) === 'boolean') {
            if ($value == false) {
                return "'false'";
            } else {
                return "'true'";
            }
        } else {
            return $value;
        }
    }
}
