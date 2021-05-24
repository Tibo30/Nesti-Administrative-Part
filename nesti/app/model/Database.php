<?php
class Database
{

    protected static $_bdd=null;
 
    /**
     * instancing bdd connection
     */
    public static function setBdd()
    {
        self::$_bdd = new PDO(DSN, USERNAME, PWD, [PDO::ATTR_PERSISTENT=>true]);
    }

    /**
     * get the bdd connection
     */
    public function getBdd(){
            return self::$_bdd;
    }

    /**
     * Disconnect
     */
    public function disconnect()
    {
        self::$_bdd = null;
    }
}
