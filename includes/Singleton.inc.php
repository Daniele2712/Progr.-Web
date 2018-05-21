<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Singleton{
    private static $DB_handler = null;

    public static DB(){
        if(!$this->DB_handler)
            $this->DB_handler = new FDatabase();
        return $this->DB_handler;
    }
}
