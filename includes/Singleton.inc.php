<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Singleton{
    private static $DB_handler = null;

    public static function DB(){
        if(!$DB_handler)
            $DB_handler = new FDatabase();
        return $DB_handler;
    }
}
