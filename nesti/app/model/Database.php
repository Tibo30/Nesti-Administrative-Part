<?php
class Database
{

    protected static $_bdd;
    // information of the database
    protected static $dbName = 'php_nesti';
    protected static $dbHost = 'localhost';
    protected static $dbUsername = 'root';
    protected static $dbUserPassword = '';
    // instancing bdd connection
    private static function setBdd()
    {
        self::$_bdd = new PDO(
            "mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName,
            self::$dbUsername,
            self::$dbUserPassword
        );
        self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    // get the bdd connection
    public static function getBdd(){
        if(self::$_bdd == null){
            self::setBdd();
            return self::$_bdd;
        }
    }

    public static function disconnect()
    {
        self::$_bdd = null;
    }
}