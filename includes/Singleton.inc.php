<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Singleton{
    private static $DB_handler = null;

    public static function DB(){
        if(!self::$DB_handler)
            self::$DB_handler = new FDatabase();
        return self::$DB_handler;
    }
}
