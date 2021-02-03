<?php
class Database
{

    // information of the database
    private $dbName = 'php_nesti';
    private $dbHost = 'localhost';
    private $dbUsername = 'root';
    private $dbUserPassword = '';

    protected $cont;
    public $table;

    public function connect()
    {
        // we first delete the former connection
        $this->cont = null;
        // then we try to connect to the database
        try {
            $this->cont = new PDO(
                "mysql:host=" . $this->dbHost . ";" . "dbname=" . $this->dbName,
                $this->dbUsername,
                $this->dbUserPassword
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $this->cont;
    }

    public function disconnect()
    {
        $this->cont = null;
    }
}