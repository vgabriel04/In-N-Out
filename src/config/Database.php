<?php

class Database
{
    public static function getConnection()
    {
        // $envPath = realpath(dirname(__FILE__) . '/../env.ini');
        // $env = parse_ini_file($envPath);
        // $conn = new mysqli($env['host'], $env['username'], $env['password'], $env['database']);

        // if ($conn->connect_error){
        //     die("Erro: " . $conn->connect_error);
        // }
        $conn = new PDO('pgsql:host=localhost;port=5432;dbname=innout;', 'postgres', '123456', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        return $conn;
    }

    public static function getResultFromQuery($sql)
    {
        $pdoConnection = self::getConnection();
        $statement = $pdoConnection->prepare($sql);
        $statement->execute();
        return $statement;
    }

    public static function executeSQL($sql)
    {
        $conn = self::getConnection();
        $statement = $conn->prepare($sql);
        $statement->execute();


        $achouinsert = strstr($sql, 'insert');
        $achouInsertGrande = strpos($sql, 'INSERT');

        if ($achouinsert !== false || $achouInsertGrande !== false) {
            $id = $conn->lastInsertId();
            return $id;
        }
        return null;
    }

    // public static function executeSQL($sql) {
    //     $conn = self::getConnection();
    //     if(!mysqli_query($conn, $sql)) {
    //         throw new Exception(mysqli_error($conn));
    //     }
    //     $id = $conn->insert_id;
    //     $conn->close();
    //     return $id;
    // }
}
