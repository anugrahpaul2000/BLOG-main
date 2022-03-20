<?php

    namespace libraries;

class Database
{
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASSWORD;
    private $dbName = DB_NAME;

    private $stmt;
    private $dbHandler;
    private $error;

    public function __construct()
    {
        $conn = 'mysql:host='. $this -> dbHost. ';dbname='.$this -> dbName;
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        try {
            $this -> dbHandler = new \PDO($conn, $this -> dbUser, $this -> dbPass, $options);
        } catch (\PDOException $e) {
            $this -> error = $e -> getMessage();
            // echo $this -> error;
        }
    }

    //Write Queries
    public function query($sql)
    {
        $this -> stmt = $this -> dbHandler -> prepare($sql);
    }

    //Bind Parameters
    public function bind($parameter, $value, $type = null)
    {
        switch (is_null($type))
        {
            case is_int($value):
                $type = \PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = \PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = \PDO::PARAM_NULL;
                break;
            default:
                $type = \PDO::PARAM_STR;
        }
        $this -> stmt -> bindValue($parameter, $value, $type);
    }

    //To execute prepared Statement
    public function execute()
    {
        return $this -> stmt -> execute();
    }

    //Return an Array
    public function resultSet()
    {
        $this -> execute();
        return $this -> stmt -> fetchAll(\PDO::FETCH_OBJ);
    }

    //Return a specific Row as Object
    public function single()
    {
        $this -> execute();
        return $this -> stmt -> fetch(\PDO::FETCH_OBJ);
    }

    //Count Row
    public function rowCount()
    {
        return $this -> stmt -> rowCount();
    }
}
