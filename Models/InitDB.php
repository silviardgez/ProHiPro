<?php
class PDOConnection{
    private static $dbhost = "127.0.0.1";
    private static $dbname = "TEC";
    private static $dbuser = "userTEC";
    private static $dbpass = "passTEC";
    private static $db_singleton = null;
    function InitDB()
    {
        if(self::$db_singleton==null){
            self::$db_singleton = new PDO(
                "mysql:host=".self::$dbhost.";dbname=".self::$dbname.";charset=utf8", 
                self::$dbuser,
                self::$dbpass,
                array( 
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        return self::$db_singleton;
    }
}
?>